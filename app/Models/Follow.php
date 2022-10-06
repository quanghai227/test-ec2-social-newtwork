<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    // users that are followed by this user
    public function userFollowing() {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }

    // users that follow this user
    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }
}
