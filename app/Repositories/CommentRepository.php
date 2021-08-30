<?php
namespace App\Repositories;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $comment,Film $film)
    {
        $this->comment = $comment;
        $this->film = $film;
    }

    /**
     * Show the form for creating a new comment.
     *
     * @return Response
     */
    public function store($data)
    {
        $validator = Validator::make($data,[
            'comment' => 'required|string|max:191',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return  [
                'success' => false,
                'message' => $validator->errors(),
            ];
        }
        try{
            $film = $this->film->where('slug',$data['slug'])->first();
            $data['film_id'] = $film->id;
            $this->comment->create($data);

            $success = true;
            $message[0] = 'Added comment successfully';
        } catch (QueryException $ex) {
            $success = false;
            $message[0] = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return $response;
    }
}
