<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Mail;
use App\Models\Notification;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    private $pathImage = "upload/surat-masuk";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $keyword = Auth::user()->id;
        $query = Mail::query();
        $query->where('mail_type', '=', '0');
        if (Auth::user()->roles[0]->name != 'admin' && Auth::user()->roles[0]->name != 'pimpinan') {
            # code...
            $query->whereHas('disposition',function($q) use($keyword){
                $q->where("user_id", $keyword);
            });
        }
        $inboxes = $query->get();
        // dd(explode(',',$inboxes->disposition->tujuan));
        $types = Type::all();
        $divisions = Division::all();
        $wadirs = User::whereHas('roles', function($q){
            $q->where('name', '=', 'wakilpimpinan');
        })->get();
        $kabids = User::whereHas('roles', function($q){
            $q->where('name', '=', 'kabid');
        })->get();
        $employees = User::whereHas('roles', function($q){
            $q->where('name', '=', 'karyawan');
        })->get();

        return view('pages.inbox.index', compact('inboxes', 'types', 'divisions', 'kabids', 'wadirs', 'employees'));
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
        $request->validate([
            '*' => 'required'
        ]);
        $files = $request->file('uploadfile');
        $fileName = $files->hashName();
        $files->move($this->pathImage,$fileName);
        // $store = $fileName->store($this->pathImage.time());
        $mail =  Mail::create([
            'user_id' => $request->user_id,
            'journal_id' => $request->journal_id,
            'number' => $request->inbox_number,
            'sender' => $request->sender,
            'destination' => $request->destination,
            'regarding' => $request->regarding,
            'entry_date' => $request->entry_date,
            'origin' => $request->inbox_origin,
            'type_id' => $request->type,
            'mail_type' => 0,
            'notes' => $request->notes,
            'status' => 0,
            'file' => $fileName
        ]);
        $users = User::whereHas('roles', function ($query) {
            $query->where('name','pimpinan');
        })->get();
        foreach ($users as $key => $value) {
            Notification::create([
                'user_id' => $value->id,
                'description' => "Surat Masuk dari $mail->sender Ref : $mail->journal_id",
                'type' => 1,
                'status' => 0
            ]);
        }
        return redirect('/inbox');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inbox = Mail::find($id);
        return response()->json([
            'status' => 1,
            'data'  => $inbox
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
        $inbox = Mail::find($id);
        return response()->json([
            'status'    => 1,
            'data'      => $inbox
        ]);
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
        try {
            $inbox = Mail::where('id', $id)->first();
            if ($request->file('uploadfile')) {
                $file = $inbox->file;
                $filename = $this->pathImage.'/' . $file;
                File::delete($filename);

                $files = $request->file('uploadfile');
                $fileName = $files->hashName();
                $files->move($this->pathImage,$fileName);
            }
            $newInbox = [
                'user_id' => $request->user_id,
                'journal_id' => $request->journal_id,
                'number' => $request->inbox_number,
                'sender' => $request->sender,
                'destination' => $request->destination,
                'regarding' => $request->regarding,
                'entry_date' => $inbox->entry_date,
                'origin' => $request->inbox_origin,
                'type_id' => $request->type,
                'mail_type' => 0,
                'notes' => $request->notes,
                'status' => 0,
                'file' =>  $request->file('uploadfile')?$fileName:$inbox->file
            ];
            $inbox->update($newInbox);
            alert('Success','Edit data berhasil', 'success' );
            return back();
        } catch (\Throwable $th) {
            alert('Gagal','Mohon hubungi admin IT', 'error' );
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inbox = Mail::where('id', $id)->first();
        $file = $inbox->file;
        $filename = $this->pathImage.'/' . $file;
        File::delete($filename);


        $inbox->delete();
        return redirect('/inbox');
    }
}
