<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use App\Models\Mail;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
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
        Disposition::create([
            'mail_id' => $request->surat_id,
            'division_id' => $request->tujuan,
            'catatan' => $request->catatan,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $inbox = Mail::where('id', '=', $request->surat_id)->first();
        $inbox->status = 2;
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
        //
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
