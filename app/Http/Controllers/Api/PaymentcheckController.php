<?php

namespace App\Http\Controllers\Api;

use App\AccountStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentcheckController extends Controller
{

    public function checkpaymentstatus(Request $request)
    {
        $userID = $request->user()->id;

        $subscription = AccountStatus::where('user_id', '=', $userID)->first();
        if(!empty($subscription)){
            if ($subscription->subscription_status == 1) {
                return response(['statusCode' => '1', 'statusMessage' => 'Subscription is active',
                    'Result' => $subscription]);
            } else {
                return response(['statusCode' => '1', 'statusMessage' => 'Subscription not active or received',
                    'Result' => $subscription]);
            }
        }
        return response(['statusCode' => '1', 'statusMessage' => 'Subscription not active or received',
            'Result' => null]);
    }


    public function updatepaymentstatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscribed_at' => 'required',
            'expiring_at' => 'required',
            'subscription_type' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMsg = $errors->all();

            return response()->json(['statusCode' => '0', 'statusMessage' => $errorMsg,
                'Result' => ''], 422);
        }

        $userID = $request->user()->id;
        $subscription = AccountStatus::where('user_id', '=', $userID)->first();

        if(!empty($subscription)){
            AccountStatus::where('user_id', '=', $userID)->update([
                'subscription_status' => 1, 'subscription_type' => $request->get('subscription_type'),
                'subscribed_at' => $request->get('subscribed_at'), 'expiring_at' => $request->get('expiring_at')
            ]);

            return response(['statusCode' => '1', 'statusMessage' => 'User subscription created/updated successfully',
                'Result' => null]);
        }
        else{
            AccountStatus::create([
                'subscription_status' => 1, 'subscription_type' => $request->get('subscription_type'),
                'subscribed_at' => $request->get('subscribed_at'), 'expiring_at' => $request->get('expiring_at'),
                'user_id' => $userID
            ]);

            return response(['statusCode' => '1', 'statusMessage' => 'User subscription created/updated successfully',
                'Result' => null]);
        }


    }

    public function validateAppPurchaseReceipt(Request $request)
    {
        $receipt = $request->get('file');
        $env = $request->get('sandbox');

        $appleSharedSecret = "6330236501cb4c72a21987bc550fcc88";
        $receiptBytes      = $receipt;
        if($env == 1){
            $appleUrl = "https://sandbox.itunes.apple.com/verifyReceipt"; // for development
        }
        else{
            $appleUrl = "https://buy.itunes.apple.com/verifyReceipt"; // for production
        }
        $request = json_encode(array("receipt-data" => $receiptBytes,"password"=>$appleSharedSecret));
        $ch = curl_init($appleUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $jsonResult = curl_exec($ch);
        curl_close($ch);

        $result2 = json_decode($jsonResult);
        return response(['statusCode' => '1', 'statusMessage' => 'Subscription response',
            'Result' => $result2]);


    }
}