<?php
namespace App\Repositories;

use App\Http\Resources\FilmResource;
use App\Models\Film;
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
        return FilmResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store($data)
    {
        $data['slug'] = Str::of($data['name'])->slug('-');
        $data['genres'] = Str::of($data['genres'])->explode(',')->filter();

        if(!empty($data['photo'])) {
            $file = fileUpload($data['photo']);
            $data['photo'] = $file;
        }

        $film = $this->film->create($data);
        $film->genres()->attach($data['genres']);
        return $film;
    }

    /**
     * This function use to show film
     * @param $id
     */
    public function show($slug)
    {
        $film = $this->film->with('country','genres')->where('slug',$slug)->get();
        return FilmResource::collection($film);
    }
}
