<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\RateType;
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

    public function show($id)
    {
        $rate = Rate::find($id);

        if($rate) {
            $years = $rate::with('rateType', 'rateType.rangeSums')->get();

            $rate['range'] = $years;

            return response(['data'=>[$rate]]);
        }


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

    public function update($id_company, $id_rate, Request $request) {

        $company = Company::find($id_company);
        $rates = $company->rates()->find($id_rate);

        $rates->title = $request->title ?? $rates->title;

        if(!$rates->save()) {
            return response([
                'status' => false,
                'message' => 'Fail to update',
                'data' => []
            ]);
        }

        return response([
            'status' => true,
            'message' => 'Oh yeah!',
            'data' => []
        ]);

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

    public function addRateType($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'range' => 'required',
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }
        
        $input = $request->all();

        $rateType = new RateType($input);
        $rate = Rate::find($id);
    
        $rate->rateType()->save($rateType);

        return response([
            'message' => 'Succesfull',
            'data' => []
        ]);

    }

    public function updateRateType($id_rate, $id_year, Request $request)
    {

        $rate = Rate::find($id_rate);
        $rateType = $rate->rateType()->find($id_year);

        $rateType->range = $request['range'] ?? $rateType->range;

        if(!$rateType->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);        

    }

    public function deleteRateType($id_rate, $id_year)
    {

        $rate = Rate::find($id_rate);
        $rateType = $rate->rateType()->find($id_year);

        if(!$rateType->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);        

    }

}
