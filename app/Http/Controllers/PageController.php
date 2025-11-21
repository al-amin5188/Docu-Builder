<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PageController extends Controller
{
    public function show()
    {
        $path = storage_path('app/json/demo_page.json');

        if(!file_exists($path)){
            dd("JSON file not found at $path");
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if(!$data){
            dd("JSON decode failed:", json_last_error_msg());
        }

        return view('demo_page', compact('data'));
    }


    public function downloadZIP()
    {
        $path = storage_path('app/json/demo_page.json');
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        $zip = new ZipArchive;
        $fileName = 'demo_page.zip';

        if ($zip->open(storage_path($fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // 1️⃣ Generate HTML content from Blade
            $html = view('demo_page', compact('data'))->render();
            $zip->addFromString('demo_page.html', $html);

            // 2️⃣ Optional: Add CSS (if needed)
            $css = file_get_contents(public_path('css/app.css')); // optional
            $zip->addFromString('style.css', $css);

            // 3️⃣ JS file (optional)
            if(file_exists(public_path('js/app.js'))){
                $zip->addFile(public_path('js/app.js'), 'js/app.js');
            }

            // 4️⃣ Images folder
            $imagesPath = public_path('images');
            if(is_dir($imagesPath)){
                $files = scandir($imagesPath);
                foreach($files as $file){
                    if(in_array($file, ['.', '..'])) continue;
                    $zip->addFile($imagesPath.'/'.$file, 'images/'.$file);
                }
            }

            $zip->close();
        }

        return response()->download(storage_path($fileName))->deleteFileAfterSend(true);
    }

}
