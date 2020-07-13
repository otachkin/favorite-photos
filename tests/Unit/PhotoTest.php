<?php


namespace Tests\Unit;

use App\Services\Photos;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    /**
     * Photo test.
     *
     * @return void
     */
    public function testGetPhotos()
    {
        $baseUrl = config('app.typicode_base_url');

        $client = new Client([
            'base_uri' => $baseUrl,
        ]);

        $photo = new Photos($client);

        $photos = $photo->limit(0,10)->get();

        $this->assertIsArray($photos);

        $this->assertIsObject($photos[0]);

    }
}
