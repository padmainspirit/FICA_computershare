<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Customer;
use App\Models\FAQData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;


class FAQ extends Controller
{
        public function ShowPage(Request $request)
        {
                $client = Auth::user();
                $Customerid = $client->CustomerId;
                $customer = Customer::where('Id', '=',  $Customerid)->first();
                $Logo = $customer['Client_Logo'];
                $customerName = $customer['RegistrationName'];
                $Icon = $customer['Client_Icon'];


                // $consumerid = $request->session()->get('LoggedUser');
                $NotificationLink = $request->session()->get('NotificationLink');
                // $Customerid = $request->session()->get('Customerid');

                $Questions = FAQData::where('Customerid', '=', $Customerid)->get();

                // $Customerid = session()->get('Customerid');


                $customerBrand = Customer::where('Id', '=',  $Customerid)->first();

                // dd($customerBrand);
                $Logo = $customerBrand['Client_Logo'];
                $Icon = $customerBrand['Client_Icon'];
                $customerName = $customerBrand['RegistrationName'];

                app('debugbar')->info($customerBrand);

                return view('FAQ', [])

                        ->with('question1', $question1)
                        ->with('question2', $question2)
                        ->with('question3', $question3)
                        ->with('question4', $question4)
                        ->with('question5', $question5)
                        ->with('question6', $question6)
                        ->with('question7', $question7)
                        ->with('question8', $question8)
                        ->with('question9', $question9)
                        ->with('question10', $question10)
                        ->with('question11', $question11)
                        ->with('question12', $question12)
                        ->with('question13', $question13)
                        ->with('question14', $question14)
                        ->with('question15', $question15)
                        ->with('question16', $question16)
                        ->with('question17', $question17)
                        ->with('question18', $question18)
                        ->with('question19', $question19)

                        ->with('answer1', $answer1)
                        ->with('answer2', $answer2)
                        ->with('answer3', $answer3)
                        ->with('answer4', $answer4)
                        ->with('answer5', $answer5)
                        ->with('answer6', $answer6)
                        ->with('answer7', $answer7)
                        ->with('answer8', $answer8)
                        ->with('answer9', $answer9)
                        ->with('answer10', $answer10)
                        ->with('answer11', $answer11)
                        ->with('answer12', $answer12)
                        ->with('answer13', $answer13)
                        ->with('answer14', $answer14)
                        ->with('answer15', $answer15)
                        ->with('answer16', $answer16)
                        ->with('answer17', $answer17)
                        ->with('answer18', $answer18)
                        ->with('answer19', $answer19)

                        ->with('NotificationLink', $NotificationLink)
                        ->with('LogUserName', $LogUserName)
                        ->with('LogUserSurname', $LogUserSurname)
                        ->with('customerName', $customerName)
                        ->with('Icon', $Icon)
                        ->with('Logo', $Logo);
        }
}
