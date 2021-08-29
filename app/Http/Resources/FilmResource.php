<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $genres = ($this->genres()->count()) ? $this->genres()->pluck('name')->implode(',') : '';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'genre' => $genres,
            'description' => $this->description,
            'rating' => $this->rating,
            'release_date' => $this->release_date,
            'country' => $this->country->name,
            'ticket_price' => $this->ticket_price,
            'photo' => $this->photo,
        ];
    }
}
