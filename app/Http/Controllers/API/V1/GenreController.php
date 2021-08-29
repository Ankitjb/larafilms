<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Genre;
use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $data = GenreResource::collection(Genre::all());
        return response()->json($data);
    }
}
