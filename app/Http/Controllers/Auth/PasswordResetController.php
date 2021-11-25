<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 23-Aug-19
 * Time: 12:59 PM
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\ForgotPasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{

    public function validateSendEmail(Request $request){
        $email = $request->get('email');
        $userDetails = User::where('email','=',$email)->first();

        if(!empty($userDetails)){
            $str = Str::random(60);
            $resetUrl = url("/reset-password/".$str);

            Mail::to($email)->send(new ForgotPasswordRequest($userDetails->first_name.' '.$userDetails->last_name,$resetUrl));
            User::where('id','=',$userDetails->id)->update([
                "reset_token" => $str
            ]);
            Session::flash('message', 'Password reset email sent. Please check your email account to continue');
            Session::flash('alert-class', 'alert-warning');
            return redirect('/reset-password');
        }
        else{
            Session::flash('message', 'No user is registered with this email');
            Session::flash('alert-class', 'alert-danger');
            return redirect('/reset-password');
        }
    }

    public function validateEmailToken($url){
        $validate = User::where('reset_token','=',$url)->first();

        if(!empty($validate)){
           $userID = $validate->id;
           return view('auth.change-password',compact('userID'));
        }
        else{
            return abort(401);
        }
    }

    public function changePassword(Request $request){
        $userID = $request->input('userID');
        $password = $request->input('newPassword');

        $userDetails = User::find($userID);
        $userDetails->password = Hash::make($password);
        $userDetails->reset_token = null;
        $userDetails->save();

        Session::flash('message', 'Your password has been changed. Please login with your new credentials');
        Session::flash('alert-class', 'alert-success');
        return redirect('login');
    }

}