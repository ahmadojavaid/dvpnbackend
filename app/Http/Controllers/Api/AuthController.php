<?php

namespace App\Http\Controllers\Api;

use App\Mail\VerifyYourAccount;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:255',
            'secondname' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ],
            [
                'username.unique' => 'Username already exists',
                'email.unique' => 'Email already exists'
            ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(
                ['statusCode' => '0', 'statusMessage' => "Error!", 'Result' => null ]
                , 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->except(['password_confirmation']));
                //Verification code generation and sending by mail
            $code = mt_rand(100000, 999999);
            Mail::to($user->email)->send(new VerifyYourAccount($user->name,$code));
            $user->verification_code = Hash::make($code);
            $user->save();

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['id' => $user->id, 'firstname' => $user->firstname,'secondname'=>$user->secondname,'username' => $user->username, 'email' => $user->email,'verification_code' => $code,
            "token" => $token];
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Account Verification Email Sent. Please Check your Inbox',
            'Result' => $response], 200);

    }

    public function userLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'emailorusername' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        }
        $user = User::where('email', $request->emailorusername)->orWhere('username',$request->emailorusername)
            ->first();

        if ($user) {
            if($user->is_verified == 0){
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                     $response = ['id' => $user->id,
                    'firstname' => $user->firstname,
                    'secondname' => $user->secondname,
                    'username' => $user->username,
                    'email' => $user->email,
                    'token' => $token];
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Please verify your account',
                    'Result' => $response], 400);
            }
            else{
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['id' => $user->id,
                        'firstname' => $user->firstname,
                        'secondname' => $user->secondname,
                        'username' => $user->username,
                        'email' => $user->email,
                        'token' => $token];                    return response()->json(['statusCode' => '1', 'statusMessage' => 'Login Successful',
                        'Result' => $response], 200);
                } else {
                    return response()->json(['statusCode' => '0', 'statusMessage' => 'User Password is Wrong',
                        'Result' => null], 400);
                }
            }

        } else {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'User Does Not Exist',
                'Result' => null], 400);
        }

    }

    public function verifyAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|min:6|max:6'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        }
        else {
            $userID = $request->user()->id;
            $userCode = $request->get('verification_code');
            $userDetails = User::find($userID);

            if(Hash::check($userCode, $userDetails->verification_code)){
                $userDetails->is_verified = 1;
                $userDetails->verification_code = null;
                $userDetails->save();
                return response()->json(['statusCode' => '1', 'statusMessage' => 'SignUp Successful', 'Result' => $userDetails]);
            }
            else{
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Verification Code is Wrong', 'Result' => null], 400);
            }
        }
    }

    public function logout(Request $request)
    {

        $token = $request->user()->token();
        $token->revoke();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'You have been successfully logged out!',
            'Result' => null], 200);

    }

    public function changeUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|max:255',
            'new_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        }

        $oldPassword = $request->get('old_password');
        $newPassword = $request->get('new_password');
        $userID = $request->user()->id;

        $user = User::find($userID);

        if (Hash::check($oldPassword, $user->password)) {
            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Password Changed Successfully!',
                'Result' => null], 200);
        } else {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Old Password Does Not Match',
                'Result' => null], 400);
        }
    }

    public function resendVerificationCode(Request $request)
    {
        $userID = $request->user()->id;
        $user = User::find($userID);
        $code = mt_rand(100000, 999999);
        Mail::to($user->email)->send(new VerifyYourAccount($user->name,$code));
        $user->verification_code = Hash::make($code);
        $user->save();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Code sent successfully! Please check your email',
            'Result' => $code], 200);
    }
}
