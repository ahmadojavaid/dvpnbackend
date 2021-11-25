<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 17-Sep-19
 * Time: 12:32 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function generateForgotPassCode(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        } else {
            $email = $request->get('email');
            $userDetails = User::where('email', '=', $email)->selectRaw("id,CONCAT(firstname,' ',secondname) as name")->first();

            if(!empty($userDetails)){
                $code = mt_rand(100000, 999999);
                Mail::to($email)->send(new ForgotPassword($userDetails->name,$code));
                $userDetails->verification_code = Hash::make($code);
                $userDetails->save();
                return response()->json(['statusCode' => '1', 'statusMessage' => 'Reset Password Email Sent. Please Check your Inbox',
                    'Result' => null,
                    "Verification Code" =>$code]);
            }
            else{
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Email Does Not Exist', 'Result' => null]);
            }

        }
    }

    public function validateCode(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required'
        ]);

        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        } else {
            $email = $request->get('email');
            $userCode = $request->get('verification_code');
            $userDetails = User::where('email', '=', $email)->first();

            if(Hash::check($userCode, $userDetails->verification_code)){
                return response()->json(['statusCode' => '1', 'statusMessage' => 'Code Verified Successfully', 'Result' => null]);
            }
            else{
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Verification Code is Wrong', 'Result' => null], 400);
            }
        }
    }

    public function updateForgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        } else {
            $email = $request->get('email');
            $newPassword = $request->get('new_password');
            $userID = User::where('email', '=', $email)->pluck("id");
            User::where('id','=',$userID)
                ->update([
                    "password" => Hash::make($newPassword),
                    "verification_code" => null
                ]);
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Password Changed Successfully', 'Result' => null]);
        }
    }
}