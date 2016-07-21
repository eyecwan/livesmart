@extends('layouts.app')

@section('content')


    <div id="app">

        <follow topic="{{$topic}}"></follow>
        <inputs list="{{$topic->inputs}}"></inputs>


    </div>




@endsection
