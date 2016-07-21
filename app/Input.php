<?php

namespace App;

use Conner\Tagging\Taggable;

use Illuminate\Database\Eloquent\Model;

// user input for specific topic 
class Input extends Model
{
    //

    protected $fillable = ['name','type','user_id'];

    use Taggable;
    use \Conner\Likeable\LikeableTrait;

    protected $tables = 'inputs';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function topic(){
        return $this->belongsTo('App\Topic');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }



}
