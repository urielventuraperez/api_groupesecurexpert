<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TitleDetail;

use Illuminate\Support\Str;
use Validator;

class InsuranceController extends Controller
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

    public function index()
    {
      $insurances = Insurance::all();

      if($insurances) {
        return response([
          'status' => true,
          'message' => 'Insurances',
          'data' => $insurances
        ]);
      } else {
        return response([
          'status' => false,
          'message' => 'doesn´t exist registers',
          'data' => []
        ]);
      }
    }

    public function getInsurancesByCompany($id_company)
    {
      $insurances = Insurance::all(['id', 'name'])->toArray();
      $details = Detail::select('insurance_id')->where('company_id', $id_company)->get();
      $available_insurances = [];

      if ($details->isEmpty()) {

        foreach($insurances as $key=>$insurance) {
          $available_insurances[$key] = $insurance;
          $available_insurances[$key]['available'] = true;
        };

        return response([
          'status' => 'true',
          'message' => 'No Insurances',
          'data' => $available_insurances
        ]);
      }

      foreach($insurances as $key=>$insurance) {
        foreach($details as $detail) {
            if($detail->insurance_id == $insurance['id'] ){
              $available_insurances[$key] = $insurance;
              $available_insurances[$key]['available'] = false;
              break;
            } else {
              $available_insurances[$key] = $insurance;
              $available_insurances[$key]['available'] = true;
            }
        }
      }

      return response([
        'status' => 'true',
        'message' => 'Get Insurances',
        'data' => $available_insurances
      ]);

    }

}