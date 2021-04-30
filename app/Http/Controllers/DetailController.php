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
    public function index()
    {
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

    public function show($id)
    {
        $detail = Details::with('files')
            ->with('rateType')
            ->with('deductibles')
            ->find($id);
        return response([
            'status' => true,
            'message' => '',
            'data' => $detail,
        ]);
    }

    public function active($id)
    {
        $detail = Details::find($id);

        if ($detail) {
            $detail->active = !$detail->active;
            try {
                $detail->save();
                return response([
                    'status' => true,
                    'message' => '',
                    'data' => $detail
                ]);
            } catch (Exception $e) {
                return response([
                    'status' => false,
                    'message' => 'Cannot update the register, try again.',
                    'data' => []
                ]);
            }
        }

        return response([
            'status' => false,
            'message' => 'Register doesn´t exists',
            'data' => []
        ]);
    }

    public function update(Request $request, $id)
    {
        $detail = Details::find($id);

        $detail->content = $request['content'] ?? $detail->content;
        $detail->note = $request['note'] ?? $detail->note;

        if (!$detail->save()) {
            return response(['status' => false, 'message' => 'retry again, cannot update the register', 'data' => []]);
        }

        return response(['status' => true, 'message' => 'Register successfully updated!', 'data' => []]);
    }
}
