@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <form action="/input/tag" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="input_id" value="{{$input->id}}">
                <div class="form-group">
                    <label>关于{{$input->topic->name}}，马友友{{$input->user->name}}说“ {{$input->name }}”</label>
                    <input type="text" name="tags" id="tags" value="{{implode(",",$tags)}}">
                </div>
                <button type="submit">确认</button>
            </form>
        </div>

    </div>

    <script>
        var tags = [
                @foreach($existingTags as $tag)
            {tag: "{{$tag}}"},
            @endforeach
        ];
    </script>
@endsection
