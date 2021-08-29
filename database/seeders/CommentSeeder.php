<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $films = Film::all();

        $films->each(function($film) {
            Comment::factory(1)
                ->create([
                    'film_id' => $film->id,
                    'user_id' => User::all()->random()->id
                ]);
        });
    }
}
