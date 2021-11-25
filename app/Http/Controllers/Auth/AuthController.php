<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 01-Oct-19
 * Time: 10:19 AM
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /**
     * user_type 1 = Author
     * user_type 2 = Admin
     */

    public function loginView()
    {
        return view('auth.login');
    }

    public function signUpView()
    {
        return view('auth.signup');
    }

    public function resetPasswordView()
    {
        return view('auth.reset-password');
    }

    public function userLogin(Request $request)
    {
        $user = User::where('email', $request->get('email'))
            ->where('user_type',2)
            ->first();

        if (!empty($user)) {
            if (Hash::check($request->get('password'), $user->password)) {

                //storing value important details in session
                Session::put('user_id', $user->id);
                Session::put('user_name', $user->firstname . ' ' . $user->secondname);
                return redirect('/');
            } else {

                Session::flash('message', 'Password is incorrect');
                Session::flash('alert-class', 'alert-danger');
                return redirect('/login');
            }
        } else {
            Session::flash('message', 'Email does not exist');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/login');
        }
    }

    public function logout()
    {
        Session::flush();
        Session::flash('message', 'You have been successfully logged out');
        Session::flash('alert-class', 'alert-success');
        return redirect('/login');
    }
}