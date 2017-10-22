<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\AlphaSpace;
use Auth;
use Session;
use App\Profile;

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
    public function edit()
    {
        return view('account.general');
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
    public function update(Request $request)
    {
        $hasname = false;
        $haslocation = false;

        if (!(is_null($request->name) || $request->name === Auth::user()->profile->name))
        {
            $this->validateWith([
                'name' => ['sometimes', 'string', new AlphaSpace, 'min:2', 'max:64']
            ]);
            $hasname = true;
        }
        if (!(is_null($request->location) || $request->location === Auth::user()->profile->location))
        {
            $this->validateWith([
                'location' => ['sometimes', 'string', new AlphaSpace, 'min:1', 'max:85'],
            ]);
            $haslocation = true;
        }
        $this->validateWith([
            'dob_day' => 'required_with:dob_month,dob_year|numeric|between:1,31',
            'dob_month' => 'required_with:dob_day,dob_year|numeric|between:1,12',
            'dob_year' => 'required_with:dob_day,dob_month|numeric|between:' . (date('Y', strtotime(date('Y-m-j'))) - 128) . ',' . (date('Y', strtotime(date('Y-m-j'))) - 13)
        ]);

        $profile = Auth::user()->profile;

        if ($hasname)
            $profile->name = $request->name;

        if ($haslocation)
            $profile->location = $request->location;

        $curDob = $profile->date_of_birth;
        $newDob = date('Y-m-d', strtotime($request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day));

        if ($newDob != $curDob)
            $profile->date_of_birth = $newDob;

        if ($profile->save())
        {
            Session::flash('status', 'success');
            Session::flash('message', 'Your account has been updated!');
        }
        else
        {
            Session::flash('status', 'danger');
            Session::flash('message', 'Your account was not updated.');
        }
        return redirect()->back();
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
        //
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
        //
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

        if (!is_null($user))
        {
            Session::flash('status', 'success');
            Session::flash('message', 'Your account has been destroyed.');
        }
        else
        {
            Session::flash('status', 'danger');
            Session::flash('message', 'Something prevented us from destroying your account!');
        }

        Auth::logout();
        $user->delete();
    }
}
