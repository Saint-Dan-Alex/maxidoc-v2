<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $files = $request->file('documents');
        $path = '';
        $folder = uniqid().'-'.now()->timestamp;

        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $file->storeAs('tmp/'.$folder, $filename);
            $path = $folder;
        }
        return $path;
    }
}
