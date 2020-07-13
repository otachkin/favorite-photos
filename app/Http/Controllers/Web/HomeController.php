<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Photos;
use App\User;
use App\UserFavoritePhoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function var_dump;


class HomeController extends Controller
{

    protected $photos;

    /**
     * HomeController constructor.
     *
     * @param Photos $photos
     */
    public function __construct()
    {
    }

    /**
     * Page for not logged user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();

        if($now->isWeekend()){
            $take = 20;
            return $this->lastFavoritedPhoto($take);
        }else{
            return $this->mostFavoriteUsers();
        }
    }

    private function lastFavoritedPhoto(){
        $photos = UserFavoritePhoto::photosFavoritedByAllUsers();
        $view_data['photos'] = $photos;
        return view('last_favorited_photos', $view_data);
    }

    private function mostFavoriteUsers(){
        $users = User::mostFavoriteUsersThisWeek();
        $view_data['users'] = $users;
        return view('most_favorite_users', $view_data);
    }

    /**
     * Page for logged only user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }
}
