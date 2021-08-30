<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FilmTest extends ApiAuthTestCase
{
    /** @test */
    public function authorisedFilmListTest($params = [])
    {
        Film::truncate();
        $resp = $this->getLoggedInUser($params);

        // Create the Genres
        $genres = Genre::factory(3)->create();

        $country = Country::factory()->create();

        // Create the User films
        $films = Film::factory(10)->create([
            'user_id' => $resp->user->id,
            'country_id' => $country->id
        ]);

        $films->each(function ($film) {
            return $film->genres()->attach(Genre::all()->random(3));
        });

        $this->assertEquals(10, $films->count());
        $this->assertEquals(3, $genres->count());
        $this->assertDatabaseHas('films', [
            'name' => $films->first()->name, 'slug' => $films->first()->slug
        ]);
        $response = $this->getJson($this->filmListRoute);
        $this->assertEquals(10, count($response->getData()));
    }

    /** @test */
    public function unauthorisedFilmListTest()
    {
        $this->enableCsrfProtection();

        $user = User::whereEmail($this->validEmail)->get()->first();
        if (!$user) {
            $user = $this->createUser();
        }

        // Create the Genres
        $genres = Genre::factory(3)->create();

        $country = Country::factory()->create();

        // Create the User films
        $films = Film::factory(10)->create([
            'user_id' => $user->id,
            'country_id' => $country->id
        ]);

        $films->each(function ($film) {
            return $film->genres()->attach(Genre::all()->random(3));
        });

        $this->assertEquals(10, $films->count());
        $this->assertEquals(3, $genres->count());
        $this->assertDatabaseHas('films', [
            'name' => $films->first()->name, 'slug' => $films->first()->slug
        ]);
        $response = $this->getJson($this->filmListRoute);
        $data = $response->getData();
        $this->assertEquals('Unauthenticated.', $data->message);
    }

    /** @test */
    public function addFilmTest($params = [])
    {
        Storage::fake('photos');

        $resp = $this->getLoggedInUser($params);

        // Create the Genres
        $genres = Genre::factory(1)->create();

        $country = Country::factory()->create();

        $response = $this->postJson($this->addFilmRoute, [
            'name' => 'test',
            'slug' => 'test',
            'description' => 'test test',
            'release_date' => now()->addDays(20)->format('Y-m-d'),
            'rating' => rand(1, 5),
            'ticket_price' => '200.0',
            'genres' => $genres->first()->id,
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'country_id' => $country->id,
            'user_id' => $resp->user->id
        ], $params);
        $data = $response->getData();
        $this->assertEquals('Added film successfully', $data->message[0]);
        $this->assertDatabaseHas('films', [
            'name' => 'test', 'slug' => 'test'
        ]);
        Storage::disk('photos')->assertMissing('missing.jpg');
    }

    /** @test */
    public function unauthorisedAddFilmTest($params = [])
    {
        Storage::fake('photos');

        $user = User::whereEmail($this->validEmail)->get()->first();
        if (!$user) {
            $user = $this->createUser();
        }

        // Create the Genres
        $genres = Genre::factory(1)->create();

        $country = Country::factory()->create();

        $response = $this->postJson($this->addFilmRoute, [
            'name' => 'test',
            'slug' => 'test',
            'description' => 'test test',
            'release_date' => now()->addDays(20)->format('Y-m-d'),
            'rating' => rand(1, 5),
            'ticket_price' => '200.0',
            'genres' => $genres->first()->id,
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'country_id' => $country->id,
            'user_id' => $user->id
        ], $params);

        $data = $response->getData();
        $this->assertEquals('Unauthenticated.', $data->message);
    }
}
