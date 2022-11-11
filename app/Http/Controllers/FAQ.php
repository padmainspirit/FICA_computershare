<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;
use App\Models\Customer;
use App\Models\FAQData;


class FAQ extends Controller
{
    public function ShowPage(Request $request)
    {

        $LogUserName = $request->session()->get('LogUserName');
        $LogUserSurname = $request->session()->get('LogUserSurname');

        // $consumerid = $request->session()->get('LoggedUser');
        $NotificationLink = $request->session()->get('NotificationLink');
        // $getconsumerid = Consumer::where('Consumerid', '=', '2D12F5FB-BE59-4A50-BD6A-3896720D8F89')->first();

        // // Get Single Array
        // $useridentitynum = ['IDNUMBER' => $getconsumerid->IDNUMBER];
        // // Get the Value for Single Array
        // $identitynum = $useridentitynum['IDNUMBER'];

        // Get Single Array
        // $consumerid = ['Customerid' => $getconsumerid->Customerid];
        // Get the Value for Single Array
        // $id = $consumerid['Customerid'];
        // $Customerid = '4717E73D-1F3F-4ACE-BE1A-0244770D6272';


        // $customerid = "4717E73D-1F3F-4ACE-BE1A-0244770D6272";

        // $testing  = DB::connection("sqlsrv2")->select(
        //     DB::raw("SET NOCOUNT ON; exec TBL_FAQ : Customerid"),
        //     [
        //         ':Customerid' => $id
        //     ]
        // );

        $distquestion1 = FAQData::where('FAQ_ID', '=', '6DAF737F-DC67-4CED-9C2C-5ABA807F9F1F')->first();
        $distquestion2 = FAQData::where('FAQ_ID', '=', '8109C425-4F5B-4556-9922-87B81BBEB325')->first();
        $distquestion3 = FAQData::where('FAQ_ID', '=', '794BD7F9-B1E5-48F0-BFED-BAA804A13B40')->first();
        $distquestion4 = FAQData::where('FAQ_ID', '=', '5CBFFCAF-9C26-4520-AC32-A8245715BE4A')->first();
        $distquestion5 = FAQData::where('FAQ_ID', '=', '12CDF112-F5B3-44C1-969F-4D66E82E5240')->first();
        $distquestion6 = FAQData::where('FAQ_ID', '=', '1B715C40-9B0E-4F5D-B552-255F1A5DE98B')->first();
        $distquestion7 = FAQData::where('FAQ_ID', '=', '2AD3181A-0A75-4194-9C9A-CACCB2843D2C')->first();
        $distquestion8 = FAQData::where('FAQ_ID', '=', 'EE0388C3-E15E-415F-967E-924DD61C9FEA')->first();
        $distquestion9 = FAQData::where('FAQ_ID', '=', 'D9875527-2F5A-4BFC-8E2F-FE4092EE5418')->first();
        $distquestion10 = FAQData::where('FAQ_ID', '=', '0B935C36-6D99-472B-B842-FF4F1B9681A4')->first();
        $distquestion11 = FAQData::where('FAQ_ID', '=', 'A0807357-BF4E-4749-B0B8-9B91D8973567')->first();
        $distquestion12 = FAQData::where('FAQ_ID', '=', '10FDC7F7-67EA-48B6-891F-3C704916FBF9')->first();
        $distquestion13 = FAQData::where('FAQ_ID', '=', '318C312E-937D-4484-8CA1-E539364FDDF0')->first();
        $distquestion14 = FAQData::where('FAQ_ID', '=', '5BFF141D-AC78-4584-9A93-39376472973C')->first();
        $distquestion15 = FAQData::where('FAQ_ID', '=', '2F834B31-CF3A-4323-9669-22043E61B465')->first(); 
        $distquestion16 = FAQData::where('FAQ_ID', '=', '906ABF90-AC3A-4C9A-A8B5-1F087F8784CB')->first();
        $distquestion17 = FAQData::where('FAQ_ID', '=', '5F0B7094-6950-4DE5-A77A-9C145A9CF36F')->first();
        $distquestion18 = FAQData::where('FAQ_ID', '=', 'B58549A2-54B7-4030-9901-9A61E5FA8FB5')->first();
        $distquestion19 = FAQData::where('FAQ_ID', '=', '846A7118-5A4C-49F9-B166-4A783C2C164A')->first();
        

        // app('debugbar')->info($distquestion1);
        // app('debugbar')->info($distquestion2);
        // app('debugbar')->info($distquestion3);
        // app('debugbar')->info($distquestion4);
        // app('debugbar')->info($distquestion5);
        // app('debugbar')->info($distquestion6);


        // Get Single Array
        $getquestion1 = ['Question' => $distquestion1->Question];
        // Get the Value for Single Array
        $question1 = $getquestion1['Question'];

        // Get Single Array
        $getquestion2 = ['Question' => $distquestion2->Question];
        // Get the Value for Single Array
        $question2 = $getquestion2['Question'];

        // Get Single Array
        $getquestion3 = ['Question' => $distquestion3->Question];
        // Get the Value for Single Array
        $question3 = $getquestion3['Question'];

        // Get Single Array
        $getquestion4 = ['Question' => $distquestion4->Question];
        // Get the Value for Single Array
        $question4 = $getquestion4['Question'];

        // Get Single Array
        $getquestion5 = ['Question' => $distquestion5->Question];
        // Get the Value for Single Array
        $question5 = $getquestion5['Question'];

        // Get Single Array
        $getquestion6 = ['Question' => $distquestion6->Question];
        // Get the Value for Single Array
        $question6 = $getquestion6['Question'];

         // Get Single Array
        $getquestion7 = ['Question' => $distquestion7->Question];
         // Get the Value for Single Array
        $question7 = $getquestion7['Question'];

        // Get Single Array
        $getquestion8 = ['Question' => $distquestion8->Question];
        // Get the Value for Single Array
        $question8 = $getquestion8['Question'];

        // Get Single Array
        $getquestion9 = ['Question' => $distquestion9->Question];
        // Get the Value for Single Array
        $question9 = $getquestion9['Question'];

        // Get Single Array
        $getquestion10 = ['Question' => $distquestion10->Question];
        // Get the Value for Single Array
        $question10 = $getquestion10['Question'];

        // Get Single Array
        $getquestion11 = ['Question' => $distquestion11->Question];
        // Get the Value for Single Array
        $question11 = $getquestion11['Question'];

        // Get Single Array
        $getquestion12 = ['Question' => $distquestion12->Question];
        // Get the Value for Single Array
        $question12 = $getquestion12['Question'];

        // Get Single Array
        $getquestion13 = ['Question' => $distquestion13->Question];
        // Get the Value for Single Array
        $question13 = $getquestion13['Question'];

        // Get Single Array
        $getquestion13 = ['Question' => $distquestion13->Question];
        // Get the Value for Single Array
        $question13 = $getquestion13['Question'];

        // Get Single Array
        $getquestion14 = ['Question' => $distquestion14->Question];
        // Get the Value for Single Array
        $question14 = $getquestion14['Question'];

        // Get Single Array
        $getquestion15 = ['Question' => $distquestion15->Question];
        // Get the Value for Single Array
        $question15 = $getquestion15['Question'];

        // Get Single Array
        $getquestion16 = ['Question' => $distquestion16->Question];
        // Get the Value for Single Array
        $question16 = $getquestion16['Question'];

         // Get Single Array
         $getquestion17 = ['Question' => $distquestion17->Question];
         // Get the Value for Single Array
         $question17 = $getquestion17['Question'];

          // Get Single Array
        $getquestion18 = ['Question' => $distquestion18->Question];
        // Get the Value for Single Array
        $question18 = $getquestion18['Question'];

         // Get Single Array
         $getquestion19 = ['Question' => $distquestion19->Question];
         // Get the Value for Single Array
         $question19 = $getquestion19['Question'];

        // app('debugbar')->info($question1);
        // app('debugbar')->info($question2);
        // app('debugbar')->info($question3);
        // app('debugbar')->info($question4);
        // app('debugbar')->info($question5);

        ///Answer

        // Get Single Array
        $getanswer1 = ['Answer' => $distquestion1->Answer];
        // Get the Value for Single Array
        $answer1 = $getanswer1['Answer'];

        // Get Single Array
        $getanswer2 = ['Answer' => $distquestion2->Answer];
        // Get the Value for Single Array
        $answer2 = $getanswer2['Answer'];

        // Get Single Array
        $getanswer3 = ['Answer' => $distquestion3->Answer];
        // Get the Value for Single Array
        $answer3 = $getanswer3['Answer'];

        // Get Single Array
        $getanswer4 = ['Answer' => $distquestion4->Answer];
        // Get the Value for Single Array
        $answer4 = $getanswer4['Answer'];

        // Get Single Array
        $getanswer5 = ['Answer' => $distquestion5->Answer];
        // Get the Value for Single Array
        $answer5 = $getanswer5['Answer'];

        // Get Single Array
        $getanswer6 = ['Answer' => $distquestion6->Answer];
        // Get the Value for Single Array
        $answer6 = $getanswer6['Answer'];

        // Get Single Array
        $getanswer7 = ['Answer' => $distquestion7->Answer];
        // Get the Value for Single Array
        $answer7 = $getanswer7['Answer'];

        // Get Single Array
        $getanswer8 = ['Answer' => $distquestion8->Answer];
        // Get the Value for Single Array
        $answer8 = $getanswer8['Answer'];

         // Get Single Array
         $getanswer9 = ['Answer' => $distquestion9->Answer];
         // Get the Value for Single Array
         $answer9 = $getanswer9['Answer'];

        // Get Single Array
         $getanswer10 = ['Answer' => $distquestion10->Answer];
         // Get the Value for Single Array
         $answer10 = $getanswer10['Answer'];

        // Get Single Array
         $getanswer11 = ['Answer' => $distquestion11->Answer];
         // Get the Value for Single Array
         $answer11 = $getanswer11['Answer'];

        // Get Single Array
         $getanswer12 = ['Answer' => $distquestion12->Answer];
         // Get the Value for Single Array
         $answer12 = $getanswer12['Answer'];

        // Get Single Array
         $getanswer13 = ['Answer' => $distquestion13->Answer];
         // Get the Value for Single Array
         $answer13 = $getanswer13['Answer'];

        // Get Single Array
         $getanswer14 = ['Answer' => $distquestion14->Answer];
         // Get the Value for Single Array
         $answer14 = $getanswer14['Answer'];

         // Get Single Array
         $getanswer15 = ['Answer' => $distquestion15->Answer];
         // Get the Value for Single Array
         $answer15 = $getanswer15['Answer'];

         // Get Single Array
         $getanswer16 = ['Answer' => $distquestion16->Answer];
         // Get the Value for Single Array
         $answer16 = $getanswer16['Answer'];

         // Get Single Array
         $getanswer17 = ['Answer' => $distquestion17->Answer];
         // Get the Value for Single Array
         $answer17 = $getanswer17['Answer'];

        // Get Single Array
         $getanswer18 = ['Answer' => $distquestion18->Answer];
         // Get the Value for Single Array
         $answer18 = $getanswer18['Answer'];


        // Get Single Array
         $getanswer19 = ['Answer' => $distquestion19->Answer];
         // Get the Value for Single Array
         $answer19 = $getanswer19['Answer'];
         

        // app('debugbar')->info($answer1);
        // app('debugbar')->info($answer2);
        // app('debugbar')->info($answer3);
        // app('debugbar')->info($answer4);
        // app('debugbar')->info($answer5);


        // return view('FAQ');

        // $customerBranding = Customer::where('Id', '=', $request->session()->get('Customerid'))->first();
        // $Logo = $customerBranding['Client_Logo'];

        // app('debugbar')->info($Logo);

        // $Logo =  $request->session()->get('Logo');
        // $customerName =  $request->session()->get('customerName');

        
        $Customerid = session()->get('Customerid');

        $customerBrand = Customer::where('Id', '=',  $Customerid)->first();
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
