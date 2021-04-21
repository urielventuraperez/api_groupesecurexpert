<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Detail;
use App\Models\Deductible;
use App\Models\Insurance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Validator;

class DashboardController extends Controller
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

    public function index() {
        $companies = Company::all();
        $users = User::all();
        
        return response([
            'status'=>true,
            'message'=>'',
            'data'=>[
                'companies' => count($companies),
                'users' => count($users),
            ]
        ]);
    }

}
