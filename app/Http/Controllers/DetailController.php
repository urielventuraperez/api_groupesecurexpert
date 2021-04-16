<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TitleDetail;
use App\Models\Detail as Details;

use Validator;

class DetailController extends Controller
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

    // Necesito devolver los insurances disponibles y todos los titulos de detalles con su contenido
    // Por compañia
    public function index() {
        $detail = TitleDetail::paginate(15);

        if ($detail) {
            return response([
                'status' => true,
                'message' => '',
                'data' => $detail
            ]);
        } else {
            
        }

    }

    public function show($id) {
        $detail = TitleDetail::findOrFail($id);
        if ($detail) {
            return response(['status' => true, 'message' => '', 'data' => $detail]);
        } else {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function createInsurance($id_company, $id_insurance) {
        
        if(empty($id_company) && empty($id_insurance)) {
            return response([
                'status' => false,
                'message' => 'Please, select an company or insurance',
                'data' => []
            ]);
        }

        $checkIfExist = Details::where('company_id', $id_company)
            ->where('insurance_id', $id_insurance)->first();
        
        if($checkIfExist) {
            return response(['status'=>false, 'message' => 'retry again, cannot save the register. Exist the detail.', 'data'=>[]]);
        }
        
        // Adjuntamos todos lso títulos de detalles
        $titleDetails = TitleDetail::all();
        foreach($titleDetails as $titleDetail) {
            $detail = new Details();
            $detail->companies()->associate($id_company);    
            $detail->insurances()->associate($id_insurance);
            $detail->titleDetails()->associate($titleDetail);
            $detail->save();
        }

        return response(['status'=>true, 'message' => 'Register successfully created!', 'data'=>[]]);

    }
    
    public function update(Request $request, $id) {
        $detail = TitleDetail::find($id);

        $detail->name = $request['name'] ?? $detail->name;
        $detail->description = $request['description'] ?? $detail->description;

        if(!$detail->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);        

    }

    public function delete($id) {
        $detail = TitleDetail::findOrFail($id);

        if(!$detail->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);


    }



}
