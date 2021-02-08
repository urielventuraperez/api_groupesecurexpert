<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Deductible;

use Validator;

class DeductibleController extends Controller
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
            'is_saving' => 'required',
            'option' => 'required',
            'applicable' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $deductible = new Deductible($input);

        $company = Company::find($id_company);
        $company->deductibles()->save($deductible);

        return response(['status'=>true, 'message'=>'save', 'data'=>[]]);

    }

    public function delete($id_company, $id_deductible) {

        $company = Company::find($id_company);
        $deductible = $company->deductibles()->find($id_deductible);

        if(!$deductible->delete()) {
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
