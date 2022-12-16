<?php


namespace App\Http\Controllers;

use App\Models\SendEmail;
use App\Models\CustomerUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{


    public function ReadNotification(Request $request)
    {
        $user = Auth::user();
        $Consumerid = $request->session()->get('LoggedUser');

        $getLogUser = CustomerUser::where('Id', '=', $Consumerid)->first();

        $LogUserName = $user->FirstName;
        $LogUserSurname =  $user->LastName;

        // $request->session()->put('LogUserName', $LogUserName);
        // $request->session()->put('LogUserSurname', $LogUserSurname);

        $NotificationLink = $request->session()->get('NotificationLink');

        // $LogUserName = $request->session()->get('LogUserName');
        // $LogUserSurname = $request->session()->get('LogUserSurname');


        // $Consumerid = $request->session()->get('LoggedUser');
        // $EmailID = SendEmail::where('EmailID', '=', $findnote->EmailID)->first();

        // $getbyemailID = SendEmail::all();
        // $byemailID = SendEmail::where('EmailID', '=', $getbyemailID)->where('IsRead', '=', '1')->first();

        app('debugbar')->info($request);

        $EmailID = $request->emailid;

        app('debugbar')->info($EmailID);

        SendEmail::where('EmailID', '=', $EmailID)->update([

            'IsRead' => 0,

        ]);

        return view('admin-dashboard', [])

            ->with('LogUserName', $LogUserName)
            ->with('LogUserSurname', $LogUserSurname)

            ->with('NotificationLink', $NotificationLink);
    }
}
