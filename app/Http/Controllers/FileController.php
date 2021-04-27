<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Carbon\Carbon;
use Exception;
use Validator;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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

    // Add file
    public function attach($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'min:2',
            'description' => 'min:5',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $file = new File();
        
        $url = Carbon::now()->format('YmdHs') . '_' . $request->file('file')->getClientOriginalName();
        $file->url = $url;

        $file->title = $request['title'] ?? $url;
        $file->description = $request['description'];
        $file->detail_id = $id;
        $file->url = $url;

        if ($file->save()) {

            $request->file('file')->storeAs("files", $file->url);

            return response([
                'status' => true,
                'message' => 'File upload succesfully',
                'data' => [
                    'title' => $file->title,
                    'description' => $file->description,
                    'url' => $file->url,
                ]
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Upload file, status fail',
            'data' => []
        ]);
    }

    public function update($id, Request $request)
    {
        $file = File::find($id);

        if ($file) {
            $file->title = $request['title'] ?? '';
            $file->description = $request['description'] ?? '';
            $file->active = !$file->active;
            try {
                $file->save();
                return response([
                    'status' => true,
                    'message' => '',
                    'data' => $file
                ]);
            } catch (Exception $e) {
                return response([
                    'status' => false,
                    'message' => 'Cannot update the register, try again. ' + $e,
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

    // Delete file
    public function delete($id)
    {
        $data = File::findOrFail($id);
        $file = $data->url;
        if (!$data->delete()) {
            return response(['status' => false, 'message' => 'retry again, cannot delete the register', 'data' => []]);
        }

        Storage::delete('files/' . $file);

        return response(['status' => true, 'message' => 'Register successfully deleted!', 'data' => []]);
    }
}
