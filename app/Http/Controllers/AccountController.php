<?php

namespace App\Http\Controllers;

use App\Events\UserUpdated;
use App\Http\Middleware\Verified;
use App\Rules\AlphaSpace;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use LaraFlash;

class AccountController extends Controller
{
    /**
     * Resource constructor
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:5,1', ['only' => ['updateSecurity', 'updateEmail']]);
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
    public function editEmail()
    {
        return view('account.email');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSecurity()
    {
        return view('account.security');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(Request $request)
    {
        $this->validateWith([
            'email' => 'required|email|confirmed'
        ]);

        $user = Auth::user();

        // Did they actually try to change the email?
        if ($request->email === $user->email)
            return redirect()->back()->withErrors(['email' => 'Your new email is the same as your old email.']);

        // Update the email
        $user->email = $request->email;

        // Handle email verification
        // If the user is already verified, then we need to generate a new token
        if ($user->verified)
        {
            $user->verified = 0;

            $key = config('app.key');

            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            DB::table('email_verifications')->insert([
                'user_id' => $user->id,
                'token' => hash_hmac('sha256', Str::random(40), $key),
                'created_at' => now()
            ]);
        }

        // Save user.
        if ($user->save())
        {
            event(new UserUpdated($user));
            return view('basic')->withTitle('Email Updated')->withMessage('Your email has been successfully changed! Please see verification email.');
        }
        else
        {
            LaraFlash::danger('A problem was encountered changing your email! Try again later.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSecurity(Request $request)
    {
        $this->validateWith([
            'password_current' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = Auth::user();

        // Validate the old password.
        if (!Hash::check($request->password_current, $user->getAuthPassword()))
            return redirect()->back()->withErrors(['password_current' => 'Incorrect current password.']);

        // Did they actually try to change the password?
        if ($request->password === $request->password_current)
            return redirect()->back()->withErrors(['password' => 'Your new password is the same as your old password.']);

        // Change the password and logout.
        $user->password = bcrypt($request->password);

        if ($user->save())
        {
            LaraFlash::success('Your password has been successfully changed!');
            Auth::logout();
            return redirect(route('login'));
        } else {
            LaraFlash::danger('A problem was encountered changing your password! Try again later.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();

        if ($user->delete())
        {
            LaraFlash::success('Your account has been destroyed.');
        }
        else
        {
            LaraFlash::danger('Something prevented us from destroying your account!');
        }

        return redirect(route('index'));
    }
}
