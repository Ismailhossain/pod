@extends('layouts.master')
@section('script')
{{--    {!! Html::script('assets/js/user/user.js') !!}--}}

    <script type="text/javascript">
        // userDetails ();
    </script>
@endsection
@section('title')
    @parent

    | Image Management
@endsection

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($errors))
        {{--@if(count($errors))--}}
        {{--@if (count($errors) > 0)--}}
        <div class="alert-danger">


            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach


        </div>
    @endif
    {{--@if ($errors->any())--}}
    {{--<ul class="alert alert-danger">--}}
    {{--@foreach ($errors->all() as $error)--}}
    {{--<li>{{ $error }}</li>--}}
    {{--@endforeach--}}
    {{--</ul>--}}
    {{--@endif--}}
    {{--<div class="alert alert-danger print-error-msg" style="display:none">--}}
    {{--<ul></ul>--}}
    {{--</div>--}}

    {{--@if(Session::has('message'))--}}
    {{--<div class="alert alert-{{ Session::get('message-type') }} alert-dismissable hidemsg">--}}
    {{--<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>--}}
    {{--<i class="{{ Session::get('message-type') == 'success' ? 'ok' : 'remove'}}"></i> {{ Session::get('message') }}--}}
    {{--<i class="glyphicon glyphicon-{{ Session::get('message-type') == 'success' ? 'ok' : 'remove'}}"></i> {{ Session::get('message') }}--}}
    {{--</div>--}}
    {{--@endif--}}

    @if (Session::has('message'))
        <div class="alert alert-info ">{{ Session::get('message') }}</div>
    @endif

    <!--Upload Form-->
    <div id="container">
        <h1 style="text-align: center;"></h1>

        <div id="body" style="text-align: center;">
        <!--<form action="<?php /*echo site_url('submit/grabData');*/?>" method="post">-->
            <form>
                Name:
                <br>
                <input id="name" type="text" name="name" /><br>
                Image:
                <br>
                <br>
                <input type="file" id="file-select" name="image" multiple/>
                <br>
                <br>
                <button id="submit_button" type="button" onclick="send_file_with_dollar_ajax()">Submit</button>
            </form>
        </div>
    </div>


    <script type="text/javascript">

        function send_file_with_dollar_ajax() {
            let name = document.getElementById('name').value;
            let file = document.getElementById('file-select');
            let files = file.files;

            let formData = new FormData();

            formData.append('image', files[0]);
            formData.append('name', name);
console.log(files[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'

                }
            });
            $.ajax({
                url : 'user/image_handler',
                type : 'POST',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    console.log(data);
                    //alert(data);
                }
            });
        }




    </script>


@endsection



