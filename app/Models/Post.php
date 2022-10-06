<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id', 'image',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function postUser(){

        return $this->belongsTo(User::class,'user_id','id')->select('id','username','avatar');
    }

    public function likes() {
        return $this->hasMany('App\Models\Like', 'post_id');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment', 'post_id');
    }
}
