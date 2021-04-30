<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail;
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

    public function create($id_detail, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'option' => 'required',
            'applicable' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $deductible = new Deductible($input);
        $detail = Detail::find($id_detail);
        if ($detail) {
            $detail->deductibles()->save($deductible);
            return response(['status' => true, 'message' => 'save', 'data' => $deductible]);
        }
        return response(['status' => false, 'message' => 'Cannot save the register', 'data' => []]);
    }

    public function update($id_deductible, Request $request)
    {
        
        $deductible = Deductible::find($id_deductible);

        if ($deductible) {

            if ($request->has('saving')) {
                $deductible->is_saving = !$deductible->is_saving;
                $deductible->save();
                return response([
                    'status' => true,
                    'message' => 'Registe updated successful.',
                    'data' => $deductible,
                ]);
            }

            $deductible->option = $request['option'] ?? $deductible->option;
            $deductible->applicable = $request['applicable'] ?? $deductible->applicable;

            $deductible->save();

            return response([
                'status' => true,
                'message' => 'Registe updated successful.',
                'data' => $deductible,
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Register not found.',
            'data' => [],
        ]);
    }

    public function delete($id_deductible)
    {

        $deductible = Deductible::find($id_deductible);

        if ($deductible) {
            if (!$deductible->delete()) {
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
        return response([
            'status' => false,
            'message' => 'Try again.',
            'data' => []
        ]);
    }
}
