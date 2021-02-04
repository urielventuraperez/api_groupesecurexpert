<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Validator;

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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'quote' => 'min:10',
            'order_url' => 'min:10'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['logo'] = $request->file('logo')->getClientOriginalName();
        $input['slug'] = Str::of($request->name)->slug('-');
        $company = new Company();
        if(!$company->create($input)) {
            return response(['status'=>false, 'message' => 'retry again, cannot save the register', 'data'=>[]]);
        }
        $request->file('logo')->storeAs('companies', $input['logo']);

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

    public function active($id) {
        $company = Company::findOrFail($id);

        $company->active = !$company->active;

        if(!$company->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);

    }


}
