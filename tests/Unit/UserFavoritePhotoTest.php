<?php

namespace Tests\Unit;

use App\UserFavoritePhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFavoritePhotoTest extends TestCase
{


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserFavoritePhoto()
    {
        $user_favorite_photo = factory(UserFavoritePhoto::class)->create();

        //dd($user_favorite_photo);
        $data = $user_favorite_photo->toArray();

        $this->assertDatabaseHas('users_favorites_photos', $data);

        $user_favorite_photo->delete();
    }
}
