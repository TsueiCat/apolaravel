<?php

namespace APOSite\Http\Controllers;

use APOSite\Http\Requests\ImageStoreRequest;
use APOSite\Models\ImageEntry;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Config;

class ImageController extends Controller
{

    public function uploadImage(ImageStoreRequest $request){
        $file = $request->file('image');
        $imgEntry = $this->storeImage($file);
        return Response::json([
            'id'=>$imgEntry->id,
            'href'=>asset(Config::get('assets.images').$imgEntry->path)
        ],200);
    }

    public function uploadFreeUseImage(ImageStoreRequest $request){
        $file = $request->file('image');
        $imgEntry = $this->storeImage($file);
        $imgEntry->free_use = true;
        $imgEntry->save();
        return Response::json([
            'id'=>$imgEntry->id,
            'href'=>asset(Config::get('assets.images').$imgEntry->path)
        ],200);
    }

    public function storeImage(UploadedFile $file)
    {
        //Assign a new file name
        $filename = md5(time().$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
        $file->move(Config::get('assets.images'),$filename);

        $i = new ImageEntry();
        $i->path = $filename;
        $i->uploader = LoginController::currentUser()->id;
        $i->save();
        return $i;
    }

    public static function FindUnusedImages()
    {
        //TODO create this method in order to figure out what we can delete
    }
}
