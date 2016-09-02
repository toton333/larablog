<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id', 'image', 'view'];

    public function category(){

    	return $this->belongsTo('App\Category');
    }

    public function tags(){

    	return $this->belongsToMany('App\Tag');
    }

    public function comments(){

    	return $this->hasMany('App\Comment');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }


}
