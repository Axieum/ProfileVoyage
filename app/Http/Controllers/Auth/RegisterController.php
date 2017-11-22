<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['verify', 'checkEmail']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // User
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Handle Email Verification
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        DB::table('email_verifications')->insert([
            'user_id' => $user->id,
            'token' => hash_hmac('sha256', Str::random(40), $key),
            'created_at' => now()
        ]);

        // User registered
        event(new UserRegistered($user));
        return $user;
    }

    /**
     * Check the availability of a request.
     *
     * @param  string  $type
     * @return json
     */
    public function verify($token)
    {
        if (!$token)
            abort(400, 'Invalid token.');

        $email_verification = DB::table('email_verifications')->where('token', $token)->first();
        if (is_null($email_verification))
            abort(404, 'Token not found!');

        $user = User::where('id', $email_verification->user_id)->first();
        if (is_null($user))
            abort(500, 'An unexpected error occurred. Please try again!');

        $user->verified = 1;
        $user->save();

        DB::table('email_verifications')->where('token', $token)->delete();

        return view('basic')->withTitle('Email Verified')->withMessage('The account bound to <b class="has-text-weight-normal">' . $user->email . '</b> has been activated!');
    }

    /**
     * Check the availability of a request.
     *
     * @param Request $request
     * @return json
     */
    public function checkEmail(Request $request)
    {
        return response()->json(!User::where('email', $request->value)->exists());
    }
}
