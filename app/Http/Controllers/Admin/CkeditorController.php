<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UploadService;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    //
    private UploadService $uploadService;
    public function __construct(UploadService  $uploadService){
        $this->uploadService = $uploadService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:20048',
        ]);
        $image = $request->file('upload');

        $imageName = time().'.'.$image->extension();

        if ($request->hasFile('upload')) {
            $fileName = $this->uploadService
                ->setModule('contents')
                ->upload($request->file('upload'));
        }



        return response()->json(['uploaded' => true, 'url' => getCdn($fileName)]);
    }
}
