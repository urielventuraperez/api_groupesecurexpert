<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Validator;

class VisitorController extends Controller
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
        $visitor = Visitor::paginate(15);

        if ($visitor) {
            return response([
                'status' => true,
                'message' => '',
                'data' => $visitor
            ]);
        } else {
            
        }

    }

    public function show($id) {
        $visitor = Visitor::findOrFail($id);
        if ($visitor) {
            return response(['status' => true, 'message' => '', 'data' => $visitor]);
        } else {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
        ]);
        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $visitor = new Visitor();
        $visitor->create($request->all());
        
        return response(['status'=>true, 'message' => 'Register successfully created!', 'data'=>[]]);

    }
    
    public function update(Request $request, $id) {
        $visitor = Visitor::find($id);

        $visitor->email = $request['email'] ?? $visitor->email;
        $visitor->city = $request['city'] ?? $visitor->city;
        $visitor->country = $request['country'] ?? $visitor->country;

        if(!$visitor->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully updated!', 'data'=>[]]);        

    }

    public function delete($id) {
        $visitor = Visitor::findOrFail($id);

        if(!$visitor->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);


    }



}
