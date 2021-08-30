<?php
namespace App\Repositories;

use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class FilmRepository implements FilmRepositoryInterface
{

    public function __construct(Film $film)
    {
        $this->film = $film;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function all()
    {
        $data =  $this->film->with('country','genres')->orderBy('created_at','desc')->get();
        return new FilmCollection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store($data)
    {
        $validator = Validator::make($data,[
            'name' => 'required|string|max:255|unique:films',
            'description' => 'required',
            'release_date' => 'required|date|date_format:Y-m-d',
            'rating' => 'required|integer|between:1,5',
            'ticket_price' => 'required|numeric',
            'country_id' => 'required',
            'genres' => 'required',
            'photo' => 'required|image|max:4000|min:1',
        ]);

        if ($validator->fails()) {
            return  [
                'success' => false,
                'message' => $validator->errors(),
            ];
        }

        $data['slug'] = Str::of($data['name'])->slug('-');
        $data['genres'] = Str::of($data['genres'])->explode(',')->filter();

        try{
            if(!empty($data['photo'])) {
                $file = fileUpload($data['photo']);
                $data['photo'] = $file;
            }

            $film = $this->film->create($data);
            $film->genres()->attach($data['genres']);

            $success = true;
            $message[0] = 'Added film successfully';
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

    /**
     * This function use to show film
     * @param $id
     */
    public function show($slug)
    {
        $film = $this->film->with('country','genres','comments.user')->where('slug',$slug)->first();
        return new FilmResource($film);
    }
}
