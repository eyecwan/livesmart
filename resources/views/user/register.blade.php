@extends('layouts.app')

@section('content')
    <h2>register user</h2>

    <div class="container">


        <div class="row">
            <div class="col-xs-4">
                <img src="{{$avatar}}" class="img-thumbnail">
            </div>
            <div class="col-xs-8">{{$name}}</div>

        </div>

        <div class="row">
            <form method="post" action="/register/create">
                {{csrf_field()}}
                <div class="radio">
                    <label>
                        <input type="radio" name="age" id="optionsRadios1" value="20" checked>
                        大学生
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="age" id="optionsRadios2" value="25">
                        职场新人
                    </label>
                </div>
                <div class="radio disabled">
                    <label>
                        <input type="radio" name="age" id="optionsRadios3" value="30">
                        资深工作党
                    </label>
                </div>
                <button type="submit">确认</button>
            </form>

        </div>
    </div>
@endsection
