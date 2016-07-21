<?php

namespace App\Http\Controllers;

use App\User;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Topic;
use App\Input;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $wechat;

    public function __construct(Application $wechat)
    {
        $this->middleware('auth');
        $this->wechat = $wechat;
    }

    public function index()
    {
        //
        $topics = Topic::all();
        foreach($topics as &$topic) {
            $topic->isFollowed = $topic->isFollowed();
        }
        return view('topic.index',compact('topics'));
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
        Topic::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

    }


    public function show(Topic $topic){
        $topic->followed = $topic->isFollowed();
        $inputs = $topic->inputs()->with('likeCounter')->with('user')->get();
        foreach ($inputs as &$input) {
            $input->isLiked = $input->liked();
        }

        $topic->inputs = $inputs;

        return view('topic.show',compact('topic'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

     *
    public function show($id)
    {
        //
        $topic = Topic::find($id);
        $existingTags = Input::existingTags()->pluck('name');
        //return $tags;

        $js = $this->wechat->js;
        $wxconfig = $js->config(array('checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'),false);
        

        return view('topic.show',compact('topic','existingTags','wxconfig'));
    }
     */


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
