<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $inboxes = Mail::where('mail_type', '=', '0')->get();
        $types = Type::all();

        return view('pages.inbox.index', compact('inboxes', 'types'));
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
            'uploadfile' => 'required',
        ]);
        $files = $request->file('uploadfile');
        $fileName = md5($files . microtime());
        // $store = $fileName->store($this->pathImage.time());
        $mail = Mail::create([
            'user_id' => $request->user_id,
            'journal_id' => $request->journal_id,
            'number' => $request->inbox_number,
            'sender' => $request->sender,
            'destination' => $request->destination,
            'regarding' => $request->regarding,
            'entry_date' => $request->entry_date,
            'origin' => $request->inbox_origin,
            'type_id' => $request->type,
            'mail_type' => 1,
            'notes' => $request->notes,
            'status' => 0,
            'file' => $fileName
        ]);
        $files->move($this->pathImage,$mail->file);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $inbox = Mail::where('id', $id)->first();
        if ($request->file('uploadfile')) {
            $file = $inbox->file;
            $filename = $this->pathImage.'/' . $file;
            File::delete($filename);

            $files = $request->file('uploadfile');
            $fileName = $files->hashName();
            $files->move($this->pathImage , $fileName);
        }
        $newInbox = [
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
            'file' =>  $request->file('uploadfile')?$fileName:$inbox->file
        ];
        $inbox->update($newInbox);
        return redirect('/inbox');
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
