<?php

namespace App;

use Conner\Likeable\LikeableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use LikeableTrait;

    protected $fillable = [
        'name', 'open_id','age','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function inputs() {
        return $this->hasMany('App\Input');
    }
    

    public static function byOpenId($open_id){
        return static::where('open_id',$open_id)->firstOrFail();
    }

    public function inputCount(){
        return $this->inputs()->count();
    }

    public function followedCount(){
        return $this->likes()->count();
    }

    public static function followCount(User $user) {
        return static::whereLiked($user->id)->get()->count();
    }
    
}
