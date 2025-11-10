<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    function index()
    {
        $images = Image::with('imageable')->get();
        return $images;
    }
}
