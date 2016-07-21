<?php

namespace App;

use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Environment\Console;


// topic for example, washing machine
class Topic extends Model
{
    //
    use LikeableTrait;
    
    protected $fillable = ['name','description'];

    public function inputs(){
        return $this->hasMany('App\Input');
    }

    public function photos(){
        return $this->hasManyThrough('App\Photo','App\Input' );
    }

    // return bool
    public function isFollowed($userID = null){
        
        return $this->liked($userID);
    }

    public function follow($userID = null) {
        $this->like($userID);
    }

    public function UnFollow($userID = null) {
        $this->unlike($userID);
    }
}
