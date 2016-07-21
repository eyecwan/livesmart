@extends('layouts.app')

@section('content')
<div class="container">


    <div class="panel">


            <h2>{{$user->name}}</h2>
            <div class="row">
                    <div class="col-xs-4">
                        <img src="{{$user->avatar}}" class="img-responsive img-rounded">
                    </div>
                    <div class="col-xs-8">
                        <button class="btn btn-success">关注</button>
                    </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p></p>
                    <p>
                        获得 <span class="glyphicon glyphicon-thumbs-up"></span>67赞同
                    </p>
                </div>

            </div>
    </div>
</div>

@endsection
