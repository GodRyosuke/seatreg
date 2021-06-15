<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\User;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function assignRoles(Request $request)
    {
        Gate::authorize('ユーザ管理');
        $ocuids = explode(',', $request['ocuids']);
        $role_name = $request['role_name'];
        foreach ($ocuids as $ocuid) {
            $assign_user = User::where('ocuid', $ocuid)->first();
            if ($assign_user) {
                $assign_user->assignRole($role_name);
            }
        }
        $user = \Auth::user();
        return view('home', compact('user'));
    }
    
}
