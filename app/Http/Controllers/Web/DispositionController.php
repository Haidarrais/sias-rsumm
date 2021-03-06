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
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            '*' => 'required'
        ]);
        // if ($request->file('file')) {
        //     $files = $request->file('file');
        //     $fileName = $files->hashName();
        //     $files->move($this->pathImage,$fileName);
        // }
        if ($validator->fails()) {
            $concatenatedMessage = '';
            $messages = $validator->messages()->get('*');
            foreach ($messages as $key => $value) {
                $concatenatedMessage = $concatenatedMessage . $value[0] . "\r\n";
            }
            alert("Error", $concatenatedMessage, 'error');
            return back();
        }
        $fileName = hash('haval160,4', $request->surat_id . 'surat ke' . $request->destinations);
        // $destinations = json_decode($request->destination);
        // dd($request->destinations);
        $status = null;
        if (Auth::user()->roles[0]->name == 'pimpinan') {
            $status = 3;
        }
        $disposition = Disposition::where('user_id', Auth::user()->id)->where('mail_id', $request->surat_id)->first();
        if ($disposition) {
            $disposition->is_disposition = 1;
            $disposition->save();
        }
        // dd($request->surat_id);
        // $data =  json_decode($request->destinations);
        $destination = explode(',', $request->destinations);
        $notifFor = explode(',', $request->destinations);
        // dd($destination);
        // $destinations = [];
        // foreach ($destination as $value) {
        //     # code...
        //     $value = json_decode($value);
        //     $value = (array) $value;
        //     // $value = implode(',', $value);
        //     array_push($destinations, $value);
        // }
        $mail = Mail::where('id', '=', $request->surat_id)->first();
        foreach ($destination as $key => $value) {
            $disp = Disposition::updateOrCreate([
                'mail_id' => $request->surat_id,
                'user_id' => $value,
            ], [
                'status' => 0,
                'mail_status' => $mail->status,
                'urgency' => $request->urgency ?? 4,
                'file' => $fileName ?? '',
                'catatan' => $request->notes ?? '-',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $this->fileDisposisi($disp);
        }
        if ($status) {
            $mail->status = $status;
            $mail->save();
        }
        // dd($mail->status);
        switch ($mail->status) {
            case 3:
                $search = 0;
                break;
            case 4:
                $search = 3;
                break;
        }
        $dispositionStat = Disposition::where('mail_status', $search)->first();
        $dispositionInc = Disposition::where('mail_status', $search)->where('is_disposition', 0)->first();
        if ($dispositionStat && !$dispositionInc) {
            switch ($search) {
                case 0:
                    $mail->status = 4;
                    $mail->save();
                    break;
                case 3:
                    $mail->status = 2;
                    $mail->save();
                    break;
                default:
                    break;
            }
        }
        $users = User::whereIn('id', $notifFor)->with('roles')->get();
        $user = Auth::user();
        foreach ($users as $key => $value) {
            Notification::create([
                'user_id' => $value->id,
                'description' => "Disposisi dari $user->name Ref : $mail->journal_id",
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
        } else {
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
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    private function fileDisposisi($disp)
    {
        // $disps = explode(',',$dis);
        // $allfile[] = '';
        $mail = Mail::where('id', '=', $disp->mail_id)->first();
        $destination = User::find($disp->user_id);
        // dd($value);
        $templateProcessor = new TemplateProcessor(public_path('templates/disp.docx'));
        $templateProcessor->setValues([
            'ddmmyyyy' => Carbon::now()->format('d/m/Y'),
            'agenda' => $mail->journal_id,
            'datemail' => (new Carbon($mail->entry_date))->format('d/m/Y'),
            'mailnumber' => $mail->number,
            'perihal' => $mail->regarding,
            'catatan' => $disp->catatan,
            'to_person' => $destination->name,
            'from_person' => $mail->sender,
            's1' => $disp->urgency == 1 ? '_*_' : '___',
            's2' => $disp->urgency == 2 ? '_*_' : '___',
            's3' => $disp->urgency == 3 ? '_*_' : '___',
            's4' => $disp->urgency == 4 ? '_*_' : '___',
        ]);
        $pathToSave = public_path('upload/disposisi/disp.docx');
        $templateProcessor->saveAs($pathToSave);

        ConvertApi::setApiSecret('nuTySpNzhyDylwUl');
        $result = ConvertApi::convert(
            'pdf',
            [
                'File' => 'upload/disposisi/disp.docx',
            ],
            'doc'
        );
        $path = "upload/disposisi/";
        $fileName = "disposisi" . $this->generateRandomString(10) . $destination->name . ".pdf";
        $result->saveFiles($path . $fileName);
        $disposition = Disposition::find($disp->id);
        $disposition->file = $fileName;
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
