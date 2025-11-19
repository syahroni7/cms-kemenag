<?php

namespace App\Http\Controllers\Management;

use App\Models\TemporaryFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function upload(Request $request)
    {
        // if($request->hasFile('productImage')){
        //     $productImages = $request->file('productImage');
        //        foreach ($productImages as $productImage) {


        if ($request->hasFile('data_file')) {
            $files = $request->file('data_file');
            $arrFolder = [];

            foreach ($files as $file) {

                $destinationPath =  storage_path('app/public/temporary');
                if(!Storage::exists($destinationPath)) {
                    Storage::makeDirectory($destinationPath, 0777, true); //creates directory
                }
                File::ensureDirectoryExists($destinationPath);


                $extension = $file->getClientOriginalExtension();
                $filename  = $file->getClientOriginalName();
                $folder    = uniqid() . '-'. now()->timestamp;
                $file->storeAs('public/temporary/' . $folder, $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename,
                ]);
                $arrFolder[] = $folder;
            }

            return $arrFolder;
        }

        return '';
    }

    // public function upload(Request $request)
    // {

    //     // Single and multiple file validation
    //     $this->validate($request, [
    //         'data_file.*' => Rule::filepond([
    //             'required',
    //             'max:2000'
    //         ])
    //     ]);

    //     $dataFiles = 'dataFile-' . auth()->id();

    //     dd($request->data_file);

    //     // $fileInfos = Filepond::field($request->data_file)
    //     //     ->moveTo('data_files/' . $dataFiles);

    //     // return $fileInfos;
    // }

    public function destroy(Request $request, $id)
    {
        $folder = json_decode($request->getContent());
        $folder = $folder[0];
        
        $this->rmdir_recursive(storage_path('/app/public/temporary/' . $folder));

        $tempFile = TemporaryFile::where('folder', $folder)->first();
        if ($tempFile) {
            $tempFile->delete();
        }

        return $folder;
    }


    public function rmdir_recursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) {
                continue;
            }
            if (is_dir("$dir/$file")) {
                $this->rmdir_recursive("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
        rmdir($dir);
    }
}
