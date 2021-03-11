<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Insurance;

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

}