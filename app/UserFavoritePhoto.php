<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserFavoritePhoto extends Model
{
    protected $table = "users_favorites_photos";
    protected $fillable = ['user_id','photo_id'];

    /**
     * @param int $take
     * @return mixed
     */
    public static function photosFavoritedByAllUsers($take = 20){
        $userCount = User::count();
        $photos =  self::select('photos.*', \DB::raw('COUNT(*) as favorite_count'))
            ->leftJoin('photos', 'users_favorites_photos.photo_id', '=', 'photos.id')
            ->groupBy('users_favorites_photos.photo_id')
            ->orderByRaw('MAX(users_favorites_photos.created_at) DESC')
            ->having('favorite_count',  $userCount)
            ->take($take)
            ->get();
        return $photos;
    }
}
