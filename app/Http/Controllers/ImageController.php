<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_bien' => 'required|integer',
        ]);

        $path = $request->file('image')->store('public/images');
        $fileName = basename($path);

        Image::create([
            'id_bien' => $request->id_bien,
            'file_path' => $fileName,
            'description' => $request->input('description', 'Sin descripción'),
        ]);

        return back()->with('success', 'Imagen subida correctamente.');
    }
}
