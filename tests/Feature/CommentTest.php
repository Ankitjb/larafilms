<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Film;

class CommentTest extends ApiAuthTestCase
{
    /** @test */
    public function addCommentTest($params = [])
    {
        $resp = $this->getLoggedInUser($params);

        $country = Country::factory()->create();

        $film = Film::factory()->create([
            'user_id' => $resp->user->id,
            'country_id' => $country->id
        ]);

        $response = $this->postJson(route('comments.store', [$film->slug]), [
            'user_id' => $resp->user->id,
            'film_id' => $film->id,
            'comment' => 'testing comments',
        ], $params);

        $data = $response->getData();
        $this->assertEquals('Added comment successfully', $data->message[0]);
        $this->assertDatabaseHas('comments', [
            'user_id' => $resp->user->id, 'comment' => 'testing comments'
        ]);
    }

}
