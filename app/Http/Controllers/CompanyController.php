<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = Company::orderBy('Id', 'DESC')->paginate(5);
        $userDet = Auth::user();
        $UserFullName = $userDet->Firstname.' '.$userDet->Surname;
        $customer = Customer::getCustomerDetails($userDet->CustomerId);
        return view('companies.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5)
            ->with('customer', $customer)
            ->with('UserFullName', $UserFullName);
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userDet = Auth::user();
        $UserFullName = $userDet->Firstname.' '.$userDet->Surname;
        $customer = Customer::getCustomerDetails($userDet->CustomerId);
        return view('companies.create')
            ->with('customer', $customer)
            ->with('UserFullName', $UserFullName);
    }



    /* function to store a new customer to the database */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Company_Name' => 'required|string|max:255||unique:companies',
        ]);

        $newCompanyId = Str::upper(Str::uuid());
        $newcompany = Company::create([
            'Id' =>  $newCompanyId,
            'Company_Name'=>$request->Company_Name,
            'Created_At' => date("Y-m-d H:i:s"),
            'Updated_At' => date("Y-m-d H:i:s"),
        ]);
        if($newcompany->save()){
            return redirect()->route('companies.index')
            ->with('success', 'Company created successfully');
        }else{
            return redirect()->route('companies.index')
            ->with('error', 'Error adding a company');
        }
    }


    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view('companies.edit', compact('company'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Company_Name' => 'required|string|max:255||unique:companies,Company_Name,'.$id.',Id',
            //'Client_Font_Code'=> ['required','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            //'Client_Logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp'
        ]);

        Company::where('Id', '=', $id)->update([
            'Company_Name' => $request->input('Company_Name'),
            'Updated_At' => date("Y-m-d H:i:s"),
        ]);
        
        return redirect()->route('companies.index')
            ->with('success', 'Company details updated successfully');

    }


    public function destroy($id)
    {
        DB::table("companies")->where('Id', $id)->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully');
    }

}
