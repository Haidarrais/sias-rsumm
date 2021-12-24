<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function memo($id=null)
    {
        if ($id) {
            $this->updateStatus($id);
        }
        switch (Auth::user()->roles[0]->name) {
            case 'pimpinan':
                $dispositions = Disposition::all();
                break;
            case 'admin':
                $dispositions = Disposition::all();
                break;
            default:
                $dispositions = Disposition::where('user_id', Auth::user()->id)->get();
                break;
        }
       return view('pages.memo.index', compact('dispositions'));
    }
    public function inbox($id)
    {
       $this->updateStatus($id);
       return redirect('/inbox');
    }
    public function outbox($id)
    {
       $this->updateStatus($id);
       return redirect('/outbox');
    }
    private function updateStatus($id){
        try {
            $notification = Notification::find($id);
            $notification->update(['status'=>1]);
        } catch (\Throwable $th) {
            alert('Error', 'Oops, something wrong');
        }
    }
}
