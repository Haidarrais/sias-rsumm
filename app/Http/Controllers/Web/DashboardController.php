<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
        $user = User::all();
        $inbox = count(Mail::where('mail_type', 0)->get());
        $outbox = count(Mail::where('mail_type', 1)->get());

        return view('pages.dashboard.index', compact('user', $user), compact('inbox'), compact('outbox'));
    }
}
