<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessImage;
use App\Models\Image;
use App\Events\ImageUploaded;

class ImageController extends Controller
{
    //
    public function index()
    {
        return view('upload');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed.
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $image = Image::create([
            'filename' => $imagePath,
        ]);

        ProcessImage::dispatch($image);

        return back()->with('success', 'Image uploaded successfully.');
    }

    public function uploadImageEvent(Request $request)
    {
        $uploadedFileName = $request->file('image')->store('images', 'public');
        $image = Image::create(['filename' => $uploadedFileName]);
        event(new ImageUploaded($image));
        return back()->with('success', 'Image uploaded successfully.');
    }
}
