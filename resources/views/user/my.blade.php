@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-4 col-xs-offset-4">
                    <p><img src="{{$user->avatar}}" class="img-circle img-responsive">
                    </p>
                    <p class="text-center">{{$user->name}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p href="/user/followUser" class="text-center">关注
                        <span>{{$user->followCount}}</span>
                    </p>
                </div>
                <div class="col-xs-4">
                    <p href="/user/followedUser" class="text-center">粉丝
                        <span>{{$user->followedCount}}</span>
                    </p>
                </div>
                <div class="col-xs-4">
                    <p href="/user/{{$user->id}}/input" class="text-center">已评论
                        <span>{{$user->inputCount}}</span>
                    </p>
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <span class="center-block"> 我点赞的评论　> </span>
            </div>
        </div>

    </div>

@endsection
