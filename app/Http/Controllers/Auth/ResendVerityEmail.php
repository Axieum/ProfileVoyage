<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerity;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Session;

class ResendVerityEmail extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:1,60');
    }

    /**
     * Send the email.
     *
     * @return void
     */
    public function send()
    {
        if (Auth::user()->verified)
            abort(403, "Already verified!");

        Mail::to(Auth::user()->email)->send(new EmailVerity(Auth::user()));

        return view('basic')->withTitle('Email Verification Resent')->withMessage('A confirmation email has been resent to <b class="has-text-weight-normal">' . Auth::user()->email . '</b>!');
    }
}
