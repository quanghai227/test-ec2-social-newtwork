<?php

namespace App\Http\Controllers\Display;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Friendships;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FollowController extends Controller
{
    public function requestAddFriend(Request $request) {
        $check = Friendships::where([
            'user_id' => $request->user_id, 
            'friend_id' => $request->friend_id
            ])->first();

        if($check) {
            return response()->json([
                'status' => 422,
                'check_empty_friend' => false
            ], 422);
        }

        $requestFriend = Friendships::create([
            'user_id' => $request->user_id,
            'friend_id' => $request->friend_id,
            'acted_user' => $request->user_id,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'friend' => $requestFriend
        ]);
    }

    public function getAllFriendOfThisUser() {
        $user = Auth::user();

        $users = $user->friendsOfThisUser;
        $friends = $users->merge($user->thisUserFriendOf);

        return response()->json([
            'friends' => $friends
        ]);
    }

    public function replyFriendRequest(Request $request) {
        $user = Auth::user();
        $friendship = Friendships::where([
            'user_id' => $request->friend_id, //user gui loi moi
            'friend_id' => $user->id, //user nhan loi moi <=> user dang nhap
        ])->first();

        //check va xoa friendship neu user dang nhap la nguoi gui
        $userFriendship = Friendships::where([
            'user_id' => $user->id,
            'friend_id' => $request->friend_id,
        ])->first();
        if ($userFriendship) {
            $userFriendship->delete();
        }

        if($friendship) {
            $replyFriend = $friendship->update([
                'status' => $request->status,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'friendship' => $replyFriend
            ]);
        }

        return response()->json([
            'friendship' => 'Not found'
        ], 404);
    }

    public function allFriendRequests() {
        $user = Auth::user();
        $users = $user->friend_requests;
        
        return response()->json([
            'friends_request' => $users,
        ]);
    }

    public function suggestedUser () {
        $user = Auth::user();
        $uid = $user->id;
        $users = $user->whereDoesntHave('userToFriend', function ($query) use ($uid) {
            $query->where('friend_id', $uid);
        })
        ->whereDoesntHave('friendToUser', function ($query) use ($uid) {
            $query->where('user_id', $uid);
        })
        ->where('id', '<>', $uid)->get();

        return response()->json([
            'suggested_user' => $users,
        ]);
    }

    public function checkRequestFriendOfUser(Request $request) {
        $user = Auth::user();
        if($user->id == $request->profile_id) {
            return response()->json([
                'check_friend' => false,
            ]);
        }
        
        $check = false;
        if($friend = Friendships::where([
            'user_id' => $user->id, 
            'friend_id' => $request->profile_id
            ])->first()
        ) {
            $check = true;
        }
        
        return response()->json([
            'check_friend' => $check,
            'friendship' => $friend,
        ]);
    }

}
