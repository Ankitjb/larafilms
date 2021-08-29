<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $data = CountryResource::collection(Country::all());
        return response()->json($data);
    }
}
