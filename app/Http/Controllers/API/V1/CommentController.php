<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store($slug, Request $request)
    {
        $request->merge(['user_id' => Auth::user()->id,'slug' => $slug]);
        $response = $this->commentRepository->store($request->all());
        return response()->json($response);
    }
}
