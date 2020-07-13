<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ControllerApi;
use App\Photo;
use App\Services\Photos;
use App\UserFavoritePhoto;
use Illuminate\Http\Request;


class ApiPhotoController extends ControllerApi
{

    protected $photos;
    protected $photos_per_page = 30;

    /**
     * ApiPhotoController constructor.
     *
     * @param Photos $photos
     */
    public function __construct(Photos $photos)
    {
        $this->middleware('auth');

        $this->photos = $photos;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user_id = \Auth::user()->id;
        $page = $request->input('page');
        $start = ($page - 1) * $this->photos_per_page;
        $photos = $this->photos->limit($start, $this->photos_per_page)->get();
        $user_favorite_photos = UserFavoritePhoto::where('user_id',$user_id)
            ->whereBetween('photo_id',[$start, $start + $this->photos_per_page])
            ->get();
        $user_favorite_photos_ids = $user_favorite_photos->pluck('photo_id')->toArray();
        array_walk($photos, function (&$value, $key) use($user_favorite_photos_ids) {
            $value->favorite = array_search($value->id, $user_favorite_photos_ids) === false ? false : true;
        });

        $this->response['photos'] = $photos;
        $this->response['total'] = 5000;

        return $this->response();
    }

    public function favorite(Request $request){
        $photo = new Photo();

        $favorited_photo = $request->only($photo->getFillable());

        $photo = $photo::firstOrCreate($favorited_photo);

        $user_id = \Auth::user()->id;

        $user_favorite_photo = UserFavoritePhoto::whereUserId($user_id)->wherePhotoId($photo->id)->first();

        if($user_favorite_photo){
            $user_favorite_photo->delete();
            $this->response['added_to_favorite'] = false;
        }else{
            $user_favorite_photo = new UserFavoritePhoto();
            $user_favorite_photo->user_id = $user_id;
            $user_favorite_photo->photo_id = $photo->id;
            $user_favorite_photo->save();
            $this->response['added_to_favorite'] = true;
        }

        return $this->response();
    }
}
