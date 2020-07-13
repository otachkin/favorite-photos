<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return mixed
     */
    public static function mostFavoriteUsersThisWeek(){
        $now = Carbon::now();
        $startWeek = $now->startOfWeek()->toDateTimeString();
        $endWeek = $now->endOfWeek()->toDateTimeString();
        $users = self::select('users.name', \DB::raw('COUNT(*) as favorite_count'))
            ->join('users_favorites_photos', 'users_favorites_photos.user_id', '=', 'users.id')
            ->whereBetween('users_favorites_photos.created_at',[$startWeek, $endWeek])
            ->groupBy('users.id')
            ->orderBy('favorite_count', 'DESC')
            ->get();
        return $users;
    }

}
