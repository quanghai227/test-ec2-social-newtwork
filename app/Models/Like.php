<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id')->select('id','username','avatar');
    }

    public function post() {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}
