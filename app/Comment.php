<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'comment', 'post_id'];

    public function user(){

    	return $this->belongsTo('App\User');
    }

    public function post(){

    	return $this->belongsTo('App\Post');
    }

}
