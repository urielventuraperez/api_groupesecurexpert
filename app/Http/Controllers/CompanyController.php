<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {
        $company = Company::paginate(15);

        if ($company) {
            return response([
                'status' => true,
                'message' => '',
                'data' => $company
            ]);
        } else {

        }

    }

    public function show($id) {
        $company = Company::findOrFail($id);
        if ($company) {
            return response(['status' => true, 'message' => '', 'data' => $company]);
        } else {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function create(Request $request) {
        $company = new Company();
        
        $company->email = $request['email'];
        $company->city = $request['city'];
        $company->country = $request['country'];

        if(!$company->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot save the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully created!', 'data'=>[]]);

    }
    
    public function update(Request $request, $id) {
        $company = Company::find($id);

        $company->email = $request['email'] ?? $company->email;
        $company->city = $request['city'] ?? $company->city;
        $company->country = $request['country'] ?? $company->country;

        if(!$company->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);        

    }

    public function delete($id) {
        $company = Company::findOrFail($id);

        if(!$company->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);


    }



}
