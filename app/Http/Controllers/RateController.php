<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Rate;

use Validator;

class RateController extends Controller
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

    public function create($id_company, Request $request) {
    
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $rate = new Rate($input);

        $company = Company::find($id_company);
        $company->rates()->save($rate);

        return response(['status'=>true, 'message'=>'save', 'data'=>[]]);

    }

    public function delete($id_company, $id_rate) {

        $company = Company::find($id_company);
        $rates = $company->rates()->find($id_rate);

        if(!$rates->delete()) {
            return response([
                'status' => false,
                'message' => 'Fail to delete',
                'data' => []
            ]);
        }

        return response([
            'status' => true,
            'message' => 'Oh yeah!',
            'data' => []
        ]);

    }



}
