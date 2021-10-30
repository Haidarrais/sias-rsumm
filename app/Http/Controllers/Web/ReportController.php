<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $inboxes = Mail::where('mail_type', '=', '0')->get();
        $outboxes = Mail::where('mail_type', '=', '1')->get();

        return view('pages.laporan.index', compact('inboxes','outboxes'));
    }
}
