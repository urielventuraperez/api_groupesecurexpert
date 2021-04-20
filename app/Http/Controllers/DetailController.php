<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TitleDetail;
use App\Models\Detail as Details;
use Exception;
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

    public function active($id) {
        $detail = Details::find($id);

        if($detail) {
            $detail->active = !$detail->active;
            try {
                $detail->save();
                return response([
                    'status'=>true,
                    'message'=>'',
                    'data'=>$detail
                ]);
            } catch(Exception $e) {
                return response([
                    'status'=>false,
                    'message'=>'Cannot update the register, try again.',
                    'data'=>[]
                ]);
            }
        }
        
        return response([
            'status'=>false,
            'message' => 'Register doesn´t exists',
            'data'=>[]
        ]);
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
