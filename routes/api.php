<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API router for your application. These
| router are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::namespace('Display')->group(function() {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::middleware('auth:api' )->group(function() {
        Route::group(['prefix' => 'user'], function () {
            Route::get('logout', 'UserController@logout');
            Route::get('userprofile/{id}', 'UserController@userProfile');
            Route::post('update-profile/{id}', 'UserController@editProfile');
        });

        Route::group(['prefix' => 'friend'], function () {
            Route::post('/friend_request', 'FollowController@requestAddFriend');
            Route::post('/reply-request-friend', 'FollowController@replyFriendRequest');
            Route::post('/check-friend', 'FollowController@checkRequestFriendOfUser');
            Route::post('/all-requests', 'FollowController@allFriendRequests');
            Route::get('/all-suggested', 'FollowController@suggestedUser');
            Route::get('/all-friends', 'FollowController@getAllFriendOfThisUser');
        });

        Route::get('/search-filter/{filter}', 'PostController@searchHome');

        Route::group(['prefix' => 'post'], function () {
            Route::get('/', 'PostController@index')->name('index');
            Route::get('/all', 'PostController@getAll');
            Route::post('/add', 'PostController@addPost');
            Route::post('/like', 'PostController@likePost');
            Route::post('/post-likes', 'PostController@getLikesByPostID');

        });

        Route::group(['prefix' => 'comment'], function () {
            Route::get('/all-comments-post/{id}', 'CommentController@getCommentsByPostID');
            Route::post('/add', 'CommentController@newComment');
        });

        Route::group(['prefix' => 'message'], function () {
            Route::get('/contacts', 'MessageController@get');
            Route::get('/conversation/{id}', 'MessageController@getMessagesFor');
            Route::post('/conversation/send', 'MessageController@send');
        });
    });

});

// Route::get('/messages', function() {
//     return App\Models\Message::with('fromContact')->get();
// });//–>middleware('auth:api');

// Route::post('/messages', function() {
//     $user = Auth::user();

//     $message = new App\Models\Message();
//     $message->text = request()->get('message', '');
//     $message->from_user = $user->id;
//     $message->to_user = $user->id + 1;
//     $message->save();

//     broadcast(new App\Events\MessagePostedRedis($message, $user))->toOthers();

//     return ['message' => $message->load('fromContact')];
// })->middleware('auth:api');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


