<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'gender', 'country', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function likes() {
        return $this->hasMany('App\Models\Like');
    }

    //users who have sent friend requests
    public function friend_requests()
	{
		return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
			        ->where('status', 'pending')->select('users.id', 'username', 'avatar');
	}

    // suggested users relationship
	public function userToFriend()
	{
		return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
	}
    public function friendToUser()
	{
		return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id');
	}
    
    // friendship that this user started
	protected function friendsOfThisUser()
	{
		return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed')
        ->select('users.id', 'username', 'avatar');
	}
    protected function thisUserFriendOf()
	{
		return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed')
        ->select('users.id', 'username', 'avatar');
	}
    protected function mergeFriends()
	{
		if($temp = $this->friendsOfThisUser) {
            return $temp->merge($this->thisUserFriendOf);
        } else {
            return $this->thisUserFriendOf;
        }
		
	}

}
