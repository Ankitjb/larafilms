<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FilmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Film::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $filmName = $this->faker->sentence(5);
        return [
            'name' => $filmName,
            'slug'   => Str::of($filmName)->slug('-'),
            'description' => $this->faker->realText(rand(100, 500)),
            'release_date'  => $this->faker->date(),
            'rating' => rand(1,5),
            'ticket_price' => rand(100,500),
            'country_id' => Country::all()->random()->id,
            'photo'  => null,
            'user_id' => User::all()->random()->id
        ];
    }
}
