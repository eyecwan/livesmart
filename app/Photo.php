<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// user upload photos belonging to specific input 
class Photo extends Model
{
    //

    protected $fillable = ['path','media_id'];

    public function input(){
        return $this->belongsTo('App\Input');
    }


}
