<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendships extends Model
{
	protected $fillable = [
        'user_id', 'friend_id', 'acted_user', 'status',
    ];
//======================== functions to get friends attribute =========================

	// friendship that this user started
	protected function friendsOfThisUser()
	{
		return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
	}

	// friendship that this user was asked for
	protected function thisUserFriendOf()
	{
		return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
	}

	// accessor allowing you call $user->friends
	public function getFriendsAttribute()
	{
		if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();
		return $this->getRelation('friends');
	}

	protected function loadFriends()
	{
		if ( ! array_key_exists('friends', $this->relations))
		{
			$friends = $this->mergeFriends();
			$this->setRelation('friends', $friends);
		}
	}

	protected function mergeFriends()
	{
		if($temp = $this->friendsOfThisUser)
		return $temp->merge($this->thisUserFriendOf);
		else
		return $this->thisUserFriendOf;
	}
//======================== end functions to get friends attribute ========================= 

//====================== functions to get blocked_friends attribute ============================

	// friendship that this user started but now blocked
	protected function friendsOfThisUserBlocked()
	{
		return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
					->withPivot('status', 'acted_user')
					->wherePivot('status', 'blocked')
					->wherePivot('acted_user', 'user_id');
	}

	// friendship that this user was asked for but now blocked
	protected function thisUserFriendOfBlocked()
	{
		return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
					->withPivot('status', 'acted_user')
					->wherePivot('status', 'blocked')
					->wherePivot('acted_user', 'friend_id');
	}

	// accessor allowing you call $user->blocked_friends
	public function getBlockedFriendsAttribute()
	{
		if ( ! array_key_exists('blocked_friends', $this->relations)) $this->loadBlockedFriends();
			return $this->getRelation('blocked_friends');
	}

	protected function loadBlockedFriends()
	{
		if ( ! array_key_exists('blocked_friends', $this->relations))
		{
			$friends = $this->mergeBlockedFriends();
			$this->setRelation('blocked_friends', $friends);
		}
	}

	protected function mergeBlockedFriends()
	{
		if($temp = $this->friendsOfThisUserBlocked)
			return $temp->merge($this->thisUserFriendOfBlocked);
		else
			return $this->thisUserFriendOfBlocked;
	}
// ======================= end functions to get block_friends attribute =========

}
