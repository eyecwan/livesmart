<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Topic;

/*
\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
});
*/

Route::get('/', function () {
    return view('welcome');
});




Route::any('/wechat', 'WechatController@serve');



Route::group(['middleware' => ['web']],function() {
//Route::group(['middleware' => ['web','wechat.oauth']],function() {
    Route::get('/home', 'HomeController@index');
    Route::post('/input/{input}/tag','InputController@tagStore');
    //Route::get('/input/tag/{tag_name}','InputController@tagIndex');

    Route::resource('/user','UserController');
    Route::get('/my','UserController@my');
    

    Route::resource('/input','InputController');
    Route::resource('/topic','TopicController');
    Route::resource('/tag','TagController');
    Route::resource('/photo','PhotoController');

    //api
    Route::get('/api/input',function(){
        return \App\Input::all();
    });
    //Route::auth();

    Route::get('register','Auth\AuthController@register');
    Route::post('register/create','Auth\AuthController@create');
    Route::get('login','Auth\AuthController@login');
    Route::get('logout',function(){
        Auth::logout();
        return redirect('/');
    });

    Route::post('/topic/{topic}/input','InputController@storeTopicInput');
    Route::get('/topic/{topic}/input/create','InputController@createTopicInput');


    Route::get('/input/{input}/like',function(\App\Input $input){
        $input->like();
    });

    Route::get('/input/{input}/unlike',function(\App\Input $input){
        $input->unlike();
    });

    Route::get('/topic/{topic}/follow',function(Topic $topic) {
        if (Auth::check()) {
            $topic->follow(Auth::user()->id);
        }

    });

    Route::get('/topic/{topic}/unfollow',function(Topic $topic) {
        if (Auth::check()) {
            $topic->unFollow(Auth::user()->id);
        }
    });

    Route::get('/user/{user}/follow',function(User $user){
       if(Auth::check()) {
           $loginUser = Auth::user();
           $user->like($loginUser->id);
       }
    });

    Route::get('/user/{user}/unfollow',function(User $user){
       if(Auth::check()) {
           $loginUser = Auth::user();
           $user->unlike($loginUser->id);
       }

    });

    Route::get('/user/{user}/input',"InputController@userInput");

    Route::get('/followUsers',function(){
        $user = Auth::user();

        //return $user->likes;
        return User::whereLiked(12)->with('likeCounter')->get();
    });

    Route::get('/followTopics',function(){
        $user = Auth::user();

        return $user->followTopics;
    });
});

Route::get('vue2',function(){
    return view('vue2');
});




//Route::get('/imageupload','WechatController@imageupload');
//Route::post('/photo/fetch','PhotoController@fetch');