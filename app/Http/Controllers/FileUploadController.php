<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Google\Client;
use Google\Service\Drive;

class FileUploadController extends Controller
{
    //
    public function fileStore(Request $request)
    {
        $request->validate([
            'files' => 'required|file|mimes:text/csv,csv|max:5120',
        ]);

        $fileName = '';
        $contentFile = '';
        $fileMimeType = '';

        foreach($request->files as $file){
            $fileName = time() . $file->getClientOriginalName(); 
            $fileMimeType = $file->getClientMimeType();
            $file->move(public_path('files'), $fileName);
            $contentFile = file_get_contents(public_path('files') . '/' . $fileName);
        }
        
        try{
            $client = new Client();
            $client->addScope(Drive::DRIVE); 
            $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
            $client->setAccessToken(env('GOOGLE_DRIVE_ACCESS_TOKEN'));
            $driveService = new Drive($client);
            $fileMetadata = new Drive\DriveFile(array(
                'name' => $fileName));
            $file = $driveService->files->create($fileMetadata, array(
                'data' => $contentFile, 
                'mimeType' => $fileMimeType, //text/csv must be
                'uploadType' => 'multipart',
                'fields' => 'id'));
        }
        catch(Exception $e){
            ddd($e);
            return back()
                ->with('error','Error in upload archive :(.');
        }

        File::create([
            'id_user' => auth()->user()->id,
            'id_file_drive' => $fileName,
        ]);
             
        return back()
            ->with('success','You have successfully upload(s) file(s) in local storage and google drive.')
            ->with('file',$fileName); 
    }
}
