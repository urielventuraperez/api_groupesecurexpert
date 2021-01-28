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
            'password' => 'required!min:6'
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required!string!min:6'
        ]);
        
        if($validator->fails()) {
            return response(['status' => false, 'message' => $validator->errors()->all(), 'data' => []]);
        }

        $user = User::where('email', $request->email)->first();

        if($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('api_groupesecurexpert')->accessToken;
                return response([ 'status' => true, 'message' => '', 'data'=>['token' => $token ] ]);
            } else {
                return response([ 'status' => false, 'message' => 'Password mismatch', 'data' => [] ]);
            }

        } else {
            return response(['status' => false, 'message' => 'User does not exist', 'data' => []]);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response(['status' => true, 'message' => 'You have been successfully logged out!']);
    }
    
}
