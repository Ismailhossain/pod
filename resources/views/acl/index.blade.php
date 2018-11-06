@extends('layouts.master')
@section('script')
    {!! Html::script('assets/js/acl/acl.js') !!}

    <script type="text/javascript">

        aclDetails();
        // window.onload=function(){
        //     document.getElementById("acl_list").addEventListener("click", aclDetails);
        // }
    </script>
@endsection
@section('title')
    @parent

    | User Management
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


    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif



    <!-- Assign With Different Roles Access -->

    {{--@if (auth()->user()->hasRole('root'))--}}
    {{--Hello Root--}}
    {{--@else--}}
    {{--Hello standard user--}}
    {{--@endif--}}



    <!-- Assign With Different Roles Access -->

    {{--        @can('Can_Register')--}}
    <!-- Button HTML (to Trigger Modal) -->

    <input type="hidden" id="all_image_url" name="all_image_url" value="{{ url('/') }}"  />

    <input type="hidden" id="user_register_token" name="user_register_token" value="{{Auth::user()->register_token}}"  />




    <div id="refreshbody">


        {!! Form::open(array( 'class'=>'form-horizontal inline','method'=>'Post','files'=> true)) !!}


        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                {{--<td>Checkbox</td>--}}
                {{--<td>ID</td>--}}
                <td>Name</td>
                <td>Image</td>
                <td>Role</td>
                <td>Permission</td>

            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr id="user_row_{{$user->id}}">
                    {{--<td><input name="cb[]" type="checkbox" value="{{{ $user->id }}}"></td>--}}
                    <td>{{{ $user->name }}}</td>
                    <td>
                        @if ($user->image)
                            <img src="{{ asset( '/images/' . $user->image)}}" style="width:60px;height:60px" class="img-polaroid" alt="">
                        @else
                            <img src="{{ asset( '/images/NoPicAvailable.png')}}" style="width:60px;height:60px" class="img-polaroid" alt="">

                        @endif
                    <td>
                        @foreach ($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </td>
                    <td>
                    @foreach($user->roles as $role)
                            <ul style="background: #0B90C4">{{ $role->name }}</ul>
                        @foreach ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                    @endforeach
                    </td>
            @endforeach



                </tr>
            </tbody>
        </table>
        {{--<div class="pagination"> {!! str_replace('/?', '?', $users->render()) !!}--}}
        {!! Form::close()  !!}

    </div>
















@endsection

