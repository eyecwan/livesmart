<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = Auth::user();
        $user->followInputs = $this->followInputs($user);
        return view('home',compact('user'));
    }
    
    public function followInputs($user){
        $inputs = [];
        $topics = Topic::whereLiked($user->id)->with('likeCounter')->get();
        foreach($topics as $topic) {
            //return $topic->inputs->take(3)->toArray();
            $inputs = array_merge($inputs,$topic->inputs->take(3)->all());
        }
        $followees = User::whereLiked($user->id)->with('likeCounter')->get();
        foreach($followees as $followee) {
            $inputs = array_merge($inputs,$followee->inputs->take(3)->all()) ;
        }
        return $inputs;
    }
}
