<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Validator;

class UserController extends Controller
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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
      
        /**Take note of this: Your user authentication access token is generated here **/
        $data['token'] =  $user->createToken('api_groupesecurexpert')->accessToken;
        $data['name'] =  $user->email;

        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
    }
    
}
