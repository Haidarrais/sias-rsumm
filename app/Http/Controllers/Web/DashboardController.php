<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
<<<<<<< HEAD
use App\Models\Type;
=======
use App\Models\Outbox;
>>>>>>> c283be542b2a32daa0e33716d79c08c47751f79a
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
<<<<<<< HEAD
        $users = User::all();
        $inboxes = Inbox::all();
        $types = Type::all();
        return view('pages.dashboard.index', compact('users','inboxes','types'));
=======
        $user = User::all();
        $inbox = count(Inbox::all());
        $outbox = count(Outbox::all());

        return view('pages.dashboard.index', compact('user', $user), compact('inbox'), compact('outbox'));
>>>>>>> c283be542b2a32daa0e33716d79c08c47751f79a
    }
}
