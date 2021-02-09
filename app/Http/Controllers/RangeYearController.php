<?php

namespace App\Http\Controllers;

use App\Models\RangeSum;
use Illuminate\Http\Request;
use App\Models\RangeYear;

use Validator;

class RangeYearController extends Controller
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

    public function addSum($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sum' => 'required',
            'value' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }
        
        $input = $request->all();

        $sum = new RangeSum($input);
        $rangeYear = RangeYear::find($id);
    
        $rangeYear->rangeSums()->save($sum);

        return response([
            'status' => 'true',
            'message' => 'Succesfull',
            'data' => []
        ]);

    }

    public function updateSum($id_range, $id_sum, Request $request)
    {

        $rangeYear = RangeYear::find($id_range);
        $rangeSum = $rangeYear->rangeSum()->find($id_sum);

        $rangeSum->sum = $request['sum'] ?? $rangeSum->sum;
        $rangeSum->value = $request['vzlue'] ?? $rangeSum->value;

        if(!$rangeSum->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);        

    }

    public function deleteeSum($id_range, $id_sum)
    {

        $rangeYear = RangeYear::find($id_range);
        $rangeSum = $rangeYear->rangeSum()->find($id_sum);

        if(!$rangeSum->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);        

    }


}
