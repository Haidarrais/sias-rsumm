<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
        $user = User::all();
        $inbox = count(Inbox::all());

        return view('pages.dashboard.index', compact('user', $user), compact('inbox'));
    }
}
