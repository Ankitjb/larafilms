<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\FilmRepositoryInterface;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function __construct(FilmRepositoryInterface $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    public function index()
    {
        $response = $this->filmRepository->all();
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => Auth::user()->id]);
        $response = $this->filmRepository->store($request->all());
        return response()->json($response);
    }

    public function show($slug)
    {
        $response = $this->filmRepository->show($slug);
        return response()->json($response);
    }
}
