<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Carbon\Carbon;

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
            'password' => 'required|min:6'
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
            'password' => 'required|string|min:6'
        ]);
        
        if($validator->fails()) {
            return response(['status' => false, 'message' => $validator->errors()->all(), 'data' => []]);
        }

        $user = User::where('email', $request->email)->first();

        if($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('api_groupesecurexpert')->accessToken;

                $lastLoggedIn = Carbon::now();
                $user->last_logged_in = $lastLoggedIn->toDateTimeString();
                $user->save();                

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
    
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $email = $request->user()->email;        
        $userUpdatePassword = User::where('email', $email)->first();

        $password = $request->password;
        $password = Hash::make($password);

        $userUpdatePassword->password = $password;

        if(!$userUpdatePassword->save()) {
            return response(['status'=>false, 'message'=>'Password change fail', 'data'=>'']);
        } else {
            return response(['status'=>true, 'message'=>'Password change Successful', 'data'=>'']);
        }
    }

    public function getUsers() {
        $users = User::all();
        if(!$users) {
            return response([ 'status'=>false, 'message'=>'No users', 'data'=>[] ]);
        }
        return response([ 'status'=>true, 'message'=>'', 'data'=>[$users] ]);
    }

}
