<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the Users
        $users = User::all()->random(3);

        // Create the Genres
        $genres = Genre::factory(3)->create();

        // Create the User films
        $users->each(function($user){
            $film = Film::factory()->create([
                'user_id' => $user->id
            ]);
            $film->genres()->attach(Genre::all()->random(3));
        });
    }
}
