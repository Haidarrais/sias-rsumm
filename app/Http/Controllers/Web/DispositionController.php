<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use App\Models\Mail;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->file('file')) {
            $files = $request->file('file');
            $fileName = $files->hashName();
            $files->move($this->pathImage,$fileName);
        }
        // $tujuans = json_decode($request->tujuan);
        // dd($request->tujuans);
        if (Auth::user()->roles[0]->name == 'pimpinan') {
            $status = 3;
        }else if (Auth::user()->roles[0]->name == 'wakilpimpinan') {
            $status = 4;
        }else if (Auth::user()->roles[0]->name == 'kabid') {
            $status = 2;
        }
        Disposition::create([
            'mail_id' => $request->surat_id,
            'tujuan' => $request->tujuans,
            'status' => 0,
            'file' => $fileName ?? '',
            'catatan' => $request->catatan?? '-',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $inbox = Mail::where('id', '=', $request->surat_id)->first();
        $inbox->status = $status;
        $inbox->save();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'superadmin')->where('name','!=', 'pimpinan');
        })->with('roles')->get();
        foreach ($users as $key => $value) {
            Notification::create([
                'user_id' => $value->id,
                'description' => 'Disposisi '.$inbox->notes,
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
}
