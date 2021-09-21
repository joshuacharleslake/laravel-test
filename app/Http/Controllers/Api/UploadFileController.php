<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{

    public function uploadFile(Request $request)
    {

        $this->validate($request,[
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);

        $file_name = time() . '.' . $request->image->extension();

        $request->image->move(public_path('uploads'), $file_name);

        return response()->json([
            'success' => 1,
            'file' => [
                'url' =>  env('APP_URL') . '/uploads/' . $file_name
            ]
        ]);

    }
}
