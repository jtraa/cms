<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imageUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')) {
            $classifiedImg = $request->file('image');
            $filename = $classifiedImg->getClientOriginalExtension();
            $image = Image::make($classifiedImg)->encode('webp', 90)->resize(200, 250)->save(public_path('images/intervention/'  .  $filename . '.webp'));

            /**
             * Main Image Upload on Folder Code
             */
            $imageName = time().'-'.$request->file('image')->getClientOriginalName();
            $destinationPath = public_path('images/intervention');
            $image->save($destinationPath.$imageName);

            /**
             * Generate Thumbnail Image Upload on Folder Code
             */
            $destinationPathThumbnail = public_path('images/thumbnail/');
            $image->encode('webp', 90);
            $image->resize(100,100);
            $image->save($destinationPathThumbnail.$imageName);

            /**
             * Write Code for Image Upload Here,
             *
             * $upload = new Images();
             * $upload->file = $imageName;
             * $upload->save();
             */

            return back()
                ->with('success','Image Upload successful')
                ->with('imageName',$imageName);
        }

        return back();
    }
}
