<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use App\Models\Mail;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class DispositionController extends Controller
{
    public $pathImage = 'upload/disposisi';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if ($request->file('file')) {
        //     $files = $request->file('file');
        //     $fileName = $files->hashName();
        //     $files->move($this->pathImage,$fileName);
        // }
        $fileName = hash('haval160,4', $request->surat_id . 'surat ke' . $request->tujuans);
        // $tujuans = json_decode($request->tujuan);
        // dd($request->tujuans);
        if (Auth::user()->roles[0]->name == 'pimpinan') {
            $status = 3;
        }else if (Auth::user()->roles[0]->name == 'wakilpimpinan') {
            $status = 4;
        }else if (Auth::user()->roles[0]->name == 'kabid') {
            $status = 2;
        }
        // $data =  json_decode($request->tujuans);
        $tujuan = explode(',', $request->tujuans);
        // dd($tujuan);
        // $tujuans = [];
        // foreach ($tujuan as $value) {
        //     # code...
        //     $value = json_decode($value);
        //     $value = (array) $value;
        //     // $value = implode(',', $value);
        //     array_push($tujuans, $value);
        // }
        $disp = Disposition::create([
            'mail_id' => $request->surat_id,
            'tujuan' => json_encode($tujuan),
            'status' => 0,
            'urgency' => $request->urgency??4,
            'file' => $fileName ?? '',
            'catatan' => $request->catatan?? '-',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $mail = Mail::where('id', '=', $request->surat_id)->first();
        $mail->status = $status;
        $mail->save();
        $this->fileDisposisi($disp, $mail);
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'superadmin')->where('name','!=', 'pimpinan');
        })->with('roles')->get();
        foreach ($users as $key => $value) {
            Notification::create([
                'user_id' => $value->id,
                'description' => 'Disposisi '.$mail->notes,
                'type' => 3,
                'status' => 0
            ]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disp = Disposition::find($id);
        return response()->json([
            'status' => 1,
            'data'  => $disp
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $disposition = Disposition::find($id);
        $disposition->status = $request->status;
        $disposition->save();

        toast('sukses update status disposisi', 'success', 'center');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $disposition = Disposition::find($id);
        if ($disposition->status == 0) {
            $disposition->status = 1;
            $disposition->save();
            toast('sukses status disposisi menjadi sudah terkonfirmasi', 'success', 'center');
        }else{
            $disposition->status = 0;
            $disposition->save();
            toast('sukses status disposisi menjadi belum terkonfirmasi', 'info', 'center');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    private function fileDisposisi($disp, $mail)
    {
        $disps = json_decode($disp->tujuan);
        // $disps = explode(',',$dis);
        // $allfile[] = '';
        foreach ($disps as $value) {
            $tujuan = User::find($value);
            // dd($value);
            $templateProcessor = new TemplateProcessor(public_path('templates/disp.docx'));
            $templateProcessor->setValues([
                'ddmmyyyy' => Carbon::now()->format('d/m/Y'),
                'agenda' => $mail->journal_id,
                'datemail' => (new Carbon($mail->entry_date))->format('d/m/Y'),
                'mailnumber' => $mail->number,
                'perihal' => $mail->regarding,
                'catatan' => $disp->catatan,
                'to_person' => $tujuan->name,
                'from_person' => $mail->sender,
                's1' => $disp->urgency == 1? '_*_':'___',
                's2' => $disp->urgency == 2? '_*_':'___',
                's3' => $disp->urgency == 3? '_*_':'___',
                's4' => $disp->urgency == 4? '_*_':'___',
            ]);
            $pathToSave = public_path('upload/disposisi/disp.docx');
            $templateProcessor->saveAs($pathToSave);

            ConvertApi::setApiSecret('nuTySpNzhyDylwUl');
            $result = ConvertApi::convert('pdf', [
                    'File' => 'upload/disposisi/disp.docx',
                ], 'doc'
            );
            $fileName = "upload/disposisi/disposisi". $this->generateRandomString(10) . $tujuan->name . ".pdf";
            $result->saveFiles($fileName);
            $allfile[] = $fileName;
        }
        // dd($allfile);
        // ConvertApi::setApiSecret('nuTySpNzhyDylwUl');
        $result = ConvertApi::convert('merge', [
                'Files' => $allfile,
            ], 'pdf'
        );
        $path = "upload/disposisi/";
        $fileNameFinal = 'disposisi-' . $this->generateRandomString(10) . "-final.pdf";
        $result->saveFiles($path . $fileNameFinal);
        $disposition = Disposition::find($disp->id);
        $disposition->file = $fileNameFinal;
        $disposition->save();
        // $domPdfPath = base_path('vendor/dompdf/dompdf');
        // Settings::setPdfRendererPath($domPdfPath);
        // Settings::setPdfRendererName('DomPDF');
        // //Load word file
        // $Content = IOFactory::load(public_path('upload/disposisi/disp.docx'));

        // //Save it into PDF
        // $PDFWriter = IOFactory::createWriter($Content,'PDF');
        // $PDFWriter->save(public_path('upload/disposisi/dispost.pdf'));
        // echo 'File has been successfully converted';
    }
}
