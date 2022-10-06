<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web router for your application. These
| router are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
//Route::group(['middleware' => 'locale'], function() {
////Route::get('change-language/{language}', 'HomeController@changeLanguage');
//});
Route::any('/{slug}', function () {
    return view('index');
})->where('slug', '.*');

//Auth::router();
//
//Route::get('/home', 'HomeController@index')->name('home');

//Kiểu này cũng khá giống kiểu subdomain, bạn sẽ thêm ngôn ngữ vào trước toàn bộ các url trong ứng dụng.

//Route::group(['prefix' => '{language}'], function ($language) {
//    config(['app.locale' => $language]); //đặt dòng này ở đầu
//
//    //Toàn bộ các route khác đặt ở đây.
//});

// Test redis
// Route::get('/chat', function() {
//     return view('chat');
// });//–>middleware('auth');

// Route::get('/getUserLogin', function() {
//     return Auth::user();
// });//–>middleware('auth');

// Route::get('/messages', function() {
//     dd(1);
//     dd(App\Models\Message::with('fromContact')->get());
//     return App\Models\Message::with('fromContact')->get();
// });//–>middleware('auth:api');

// Route::post('/messages', function() {
//     $user = Auth::user();

//     $message = new App\Models\Message();
//     $message->text = request()->get('message', '');
//     $message->from_user = $user->id;
//     $message->save();

//     broadcast(new App\Events\MessagePostedRedis($message, $user))->toOthers();

//     return ['message' => $message->load('fromContact')];
// })->middleware('auth');
