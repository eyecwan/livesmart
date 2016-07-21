<?php

namespace App\Http\Controllers;

use App\Topic;
use App\User;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Input;

use App\Repositories\PhotoFetchRepository;

class InputController extends Controller
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
        $inputs = Input::all();
        //return $inputs;
        return $inputs;
        //return view('input.index2',compact('inputs'));
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
        //save the input with topic id


        // breturn $request->user()->inputs();
        $input = $request->user()->inputs()->create([
                'name'=> $request->input,
                'topic_id'=>$request->topic_id,
            ]
        );

        
        // save tags
        if ($request->tags !== ''){
            $input->retag(explode(',',$request->tags ));
        }


        // fetch photo and save photo

        $photo_fetch = new PhotoFetchRepository();
        $photo = $photo_fetch->fetchFromMediaId($request->media_id);
        Log::info($photo);
        $photo->input()->associate($input);
        $photo->save();
        return redirect('/topic/'.$request->topic_id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

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
        $input = Input::find($id);
        $existingTags = Input::existingTags()->pluck('name');
        $tags = $input->tagNames();
        //return $tags;
        return view('input.edit',compact('tags','input','existingTags'));
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
    public function destroy(Input $input)
    {
        if (Auth::user()->id === $input->user_id){
            $input->delete();
        }

    }


    public function storeTopicInput(Topic $topic,Request $request){
        $input = $topic->inputs()->create([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => Auth::user()->id
        ]);
        return $input;
    }

    public function createTopicInput(Topic $topic){
        $user = Auth::user();
        $topic->inputs = $user->inputs()->where('topic_id',$topic->id)->get();
        $topic->user = $user;
        foreach ($topic->inputs as &$input){
            $tagNames = $input->tagNames();
            $input->tags = $tagNames;
        }
        return view('input.leaveinput',compact('topic'));
    }

    public function userInput(User $user){
        $inputs =  $user->inputs()->with('likeCounter')->with('user')->with('topic')->get();
        return view('input.index',compact('inputs'));
    }

    public function tagStore(Input $input, Request $request){
        //return $request->all();
        $input->tag(explode(',',$request->tags ));
        //return redirect('/input/'.$request->input_id.'/edit');
    }

    public function tagIndex($tag_name){
        return Input::withAnyTag([$tag_name])->get();

    }
}
