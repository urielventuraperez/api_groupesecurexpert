<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Detail;

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

    public function index() {
        $detail = Detail::paginate(15);

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
        $detail = Detail::findOrFail($id);
        if ($detail) {
            return response(['status' => true, 'message' => '', 'data' => $detail]);
        } else {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function create(Request $request) {
        $detail = new Detail();
        
        $detail->email = $request['email'];
        $detail->city = $request['city'];
        $detail->country = $request['country'];

        if(!$detail->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot save the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully created!', 'data'=>[]]);

    }
    
    public function update(Request $request, $id) {
        $detail = Detail::find($id);

        $detail->email = $request['email'] ?? $detail->email;
        $detail->city = $request['city'] ?? $detail->city;
        $detail->country = $request['country'] ?? $detail->country;

        if(!$detail->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);        

    }

    public function delete($id) {
        $detail = Detail::findOrFail($id);

        if(!$detail->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);


    }



}
