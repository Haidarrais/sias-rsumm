<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $mails = Mail::all();
        return view('pages.laporan.index', compact('mails'));
    }
}
