<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
        $users = User::all();
        $inboxes = Inbox::all();
        $types = Type::all();
        return view('pages.dashboard.index', compact('users','inboxes','types'));
    }
}
