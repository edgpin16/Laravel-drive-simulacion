<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileUploadController extends Controller
{
    //
    public function fileStore(Request $request)
    {
        $request->validate([
            'files' => 'required|file',
        ]);

        $fileName = '';

        foreach($request->files as $file){
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
        }

        File::create([
            'id_user' => auth()->user()->id,
            'id_file_drive' => $fileName,
        ]);
             
        return back()
            ->with('success','You have successfully upload(s) file(s).')
            ->with('file',$fileName); 
    }
}
