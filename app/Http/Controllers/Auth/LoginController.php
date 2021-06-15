<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Session;
use Redirect;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // protected $loginPath = '/ssologin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->api_token) {
            $user->update(['api_token' => Str::random(60)]);
        }
    }

    public function ssoLogin(Request $request)
    {
        $uid = User::getPrimaryIdFromSSO();
        $result = User::getUserInfoFromLDAP($uid);
        if ($result) {
            $ocuid = User::getOcuidFromLDAP($result);
            $user = User::where('primaryid', $uid)->first();
            if ($user) {
                $user->updateUserFromLDAP();
            } else {
                $user = User::create([
                    'ocuid' => $uid,
                    'primaryid' => $uid,
                    'name' => 'dummy',
                    'email' => 'dummy',
                    'password' => bcrypt('secret'),
                ]);
                $user->refresh();
                $user->updateUserFromLDAP();
                $user->refresh();
            }
            \Auth::login($user);
            $url = Session::get('redirect_from', 'home');
            Session::forget('redirect_from');
            return redirect($url);
        }
        return \App::abort(403, 'Access denied login:  ocuid=' . $ocuid . ', REMOTE_ADDR=' . ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? ($_SERVER['REMOTE_ADDR'] ?? null)) );
    }
 
    public function logout(Request $request)
    {
        $this->guard()->logout();
    
        $request->session()->flush();
        $request->session()->regenerate();
    
        return redirect('/');
    }
}



