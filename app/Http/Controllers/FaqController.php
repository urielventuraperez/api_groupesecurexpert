<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Faq;

use Illuminate\Support\Str;
use Validator;

class FaqController extends Controller
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
        $faq = Faq::where('active', 1)->get();

        if ($faq) {
            return response([
                'status' => true,
                'message' => '',
                'data' => $faq
            ]);
        } else {

        }

    }

    public function show($id) {
        $faq = Faq::findOrFail($id);
        if ($faq) {
            return response(['status' => true, 'message' => '', 'data' => $faq]);
        } else {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'ask' => 'required',
            'answer' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['slug'] = Str::of($request->ask)->slug('-');
        $faq = new Faq();
        $faq::create($input);

        return response(['status'=>true, 'message' => 'Register successfully created!', 'data'=>[]]);

    }
    
    public function update(Request $request, $id) {
        $faq = Faq::find($id);

        $faq->ask = $request['ask'] ?? $faq->ask;
        $faq->answer = $request['answer'] ?? $faq->answer;

        if(!$faq->save()) {
            return response(['status'=>false, 'message' => 'retry again, cannot update the FAQ', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'FAQ successfully updated!', 'data'=>[]]);        

    }

    public function delete($id) {
        $faq = Faq::findOrFail($id);

        if(!$faq->delete()) {
            return response(['status'=>false, 'message' => 'retry again, cannot delete the register', 'data'=>[]]);
        }

        return response(['status'=>true, 'message' => 'Register successfully deleted!', 'data'=>[]]);
    }



}
