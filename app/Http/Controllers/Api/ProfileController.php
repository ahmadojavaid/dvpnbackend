<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 23-Sep-19
 * Time: 5:05 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfileDetails(Request $request)
    {
        $userID = $request->user()->id;
        $userDetails = User::find($userID);

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Showing User Profile Details',
            'Result' => $userDetails], 200);
    }

    public function updateProfile(Request $request)
    {
        $userID = $request->user()->id;
        $userDetails = User::find($userID);

        if($userDetails->email == $request->email)
        {
            $userDetails->update($request->all());
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Profile Updated Successfully',
                'Result' => $userDetails]);
        }
        else{
            $validate = User::where('email','=',$request->email)->first();

            if(!empty($validate)){
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Email is already associated with a user', 'Result' => null]);
            }
            else{
                $userDetails->update($request->all());
                return response()->json(['statusCode' => '1', 'statusMessage' => 'Profile Updated Successfully',
                    'Result' => $userDetails]);
            }
        }
    }
}