<?php

namespace App\Http\Controllers;

use App\Input;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $user->inputCount = $user->inputCount();
        $user->followedCount = $user->followedCount();
        $user->followCount = User::followCount($user);
        $user->isFollowed = $user->liked();

        $inputs = $user->inputs()->with("likeCounter")->get();
        $user->inputLikeCount = $inputs->sum(function($input) {
            if(! is_null($input->likeCounter)){
                return $input->likeCounter->count;
            }
        });
        return view('user.show',compact('user'));
    }

    // display user myself
    public function my(){
        //return dd($request->user());
        if (Auth::check()){
            $user = Auth::user();
            $user->inputCount = $user->inputs()->count();
            $user->followedCount = $user->likeCount;
            $user->followCount = User::whereLiked($user->id)->count();
            return view('user.my',compact('user'));

        }

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
