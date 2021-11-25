<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 29-Oct-19
 * Time: 3:15 PM
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function loadView()
    {
        $totalUsers = User::count();
        $totalSubscribedUsers = User::join('account_status','account_status.user_id','=','users.id')
            ->where('subscription_status','=',1)->count();
        $users = User::all();
        return view('dashboard',compact('totalUsers','totalSubscribedUsers','users'));
    }

    public function deactivateUser($userID)
    {
        $user = User::find($userID);
        $user->active = 0;
        $user->save();

        Session::flash('message', 'User deactivated successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect('/');
    }
}