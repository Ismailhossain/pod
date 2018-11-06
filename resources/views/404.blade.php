

@extends('layouts.master')


@section('title')
    @parent

    | 404 page
@stop

@section('content')

    @if(isset($errors))
        <div class="alert-danger">


            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach


        </div>
    @endif


    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <br>

  <center> You don't have the current Authorization to access this page.</center>

<br>

@stop







