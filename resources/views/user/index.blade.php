@extends('layouts.master')
@section('script')
    {!! Html::script('assets/js/user/user.js') !!}

    <script type="text/javascript">
        // userDetails ();
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

    <button type="button" id="insertUser" class="btn btn-primary">Add User</button>
    <input type="hidden" id="user_edit_value" value="">
    <input type="hidden" id="all_image_url" name="all_image_url" value="{{ url('/') }}"/>

    {{--<button type="button" id="insertUser" class="btn btn-primary" data-toggle="modal" data-target="#ModalUser">Open Modal</button>--}}

    {{--@endcan--}}
    <!-- Modal no need to put tabindex="-1" so that can edit in kendo edit-->

    <div id="ModalUser" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"
         aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog  modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body">
                    {!!   Form::open(array( 'method'=>'post',  'id'=>'NewUserSave',  'class'=>'form-horizontal inline','files'=> true)) !!}
                    {{--                    {!!   Form::open(array( 'url' => 'user/store', 'id'=>'UserDataSave', 'method'=>'post',  'class'=>'form-horizontal inline','files'=> true)) !!}--}}
                    {{--<form method="post", id="NewUserSave" , enctype="multipart/form-data" class="form-horizontal inline">--}}
                    {{--@csrf--}}
                    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
                    <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="">
                    <input type="hidden" name="hidden_user_image" id="hidden_user_image" value="">

                    <div class=" form-group">
                        <label for="name" class="col-sm-4 control-label">{{ __('Name') }}</label>

                        <div class="col-sm-6">
                            <input id="name" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                   value="{{ old('name') }}" autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class=" form-group">
                        <label for="username" class="col-sm-4 control-label">{{ __('Username') }}</label>

                        <div class="col-sm-6">
                            <input id="username" type="text"
                                   class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                   name="username" value="{{ old('username') }}">

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class=" form-group">
                        <label for="email" class="col-sm-4 control-label">{{ __('Email') }}</label>

                        <div class="col-sm-6">
                            <input id="email" type="text"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_id" class="col-sm-4 control-label">{{ __('Status') }}</label>
                        <div class="col-sm-6">
                            <select name="status_id" id="status_id" class="form-control">
                                <option value="" selected disabled>Please select a Role</option>
                                @foreach($status as $status_row)
                                    <option value="{{$status_row->status_id}}">{{$status_row->status_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role_title" class="col-sm-4 control-label">Role</label>

                        <div class="col-sm-6">
                            {{--<select name="roles" id="roles" class="form-control" >--}}
                            <select name="role_name[]" id="role_name" class="form-control" multiple="multiple">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=" form-group" id="hide_password">
                        <label for="password" class="col-sm-4 control-label">{{ __('Password') }}</label>

                        <div class="col-sm-6">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" value="{{ old('password') }}">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class=" form-group" id="hide_password_confirmation">
                        <label for="password_confirmation"
                               class="col-sm-4 control-label">{{ __('Confirm Password') }}</label>

                        <div class="col-sm-6">
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group" id="RefreshUserFile">
                        <label for="user_image" class="col-sm-4 control-label">Photograph</label>

                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="user_image" id="user_image">
                            <span id="user_image_url">
                                <span id="no_image_added1"></span>
                                <img style="width:60px; height: 60px" src="" id="my_user_image_url"/>
                            </span>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="reset" id="clear_modal" onclick="" class="btn btn-default">Clear</button>
                    <button type="submit" id="save_user_data" onclick="" class="btn btn-default">Save</button>
                </div>
                {!! Form::close() !!}
                {{--</form>--}}
            </div>

        </div>
    </div>



    </br></br>


    <div id="refreshbody">


        {!! Form::open(array( 'class'=>'form-horizontal inline','method'=>'get','files'=> true)) !!}


        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                {{--<td>Checkbox</td>--}}
                {{--<td>ID</td>--}}
                <td>Name</td>
                <td>Image</td>
                <td>Role</td>
                {{--                @can('Can_Edit')--}}
                <td>Actions</td>
                {{--@endcan--}}
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr id="user_row_{{$user->id}}">
                    {{--<td><input name="cb[]" type="checkbox" value="{{{ $user->id }}}"></td>--}}
                    <td>{{{ $user->name }}}</td>
                    <td>
                        @if ($user->image)
                            <img src="{{ asset( '/images/' . $user->image)}}" style="width:60px;height:60px"
                                 class="img-polaroid" alt="">
                        @else
                            <img src="{{ asset( '/images/NoPicAvailable.png')}}" style="width:60px;height:60px"
                                 class="img-polaroid" alt="">

                        @endif

                    </td>
                    <td>
                        @foreach ($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </td>
                    {{--                    @can('Can_Edit')--}}
                    <td>
                        <input type='button' class="btn btn-small btn-info" id="edit_button<?php echo $user->id; ?>"
                               value="Edit" onclick="edit_user('<?php echo $user->id; ?>');">
                        <input type='button' class="btn btn-small btn-danger" id="delete_button<?php echo $user->id; ?>"
                               value="Delete" onclick="delete_user('<?php echo $user->id; ?>');">
                    </td>

                    {{--<td>--}}
                    {{--<a class="btn btn-small btn-info" id="user_edit" value="{{$user->id}}" href="{{url('user/edit/'.$user->id)}}">Edit</a>--}}
                    {{--<a class="btn btn-small btn-danger" id="user_delete" value="{{$user->id}}" href="{{ url('user/destroy/' . $user->id) }}">Delete</a>--}}
                    {{--</td>--}}
                    {{--@endcan--}}
                    {{--@endif--}}
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--        <div class="pagination"> {!! str_replace('/?', '?', $users->render()) !!}--}}
        {!! Form::close()  !!}

    </div>






    <div id="UserGrid">


    </div>

    <script id="template" type="text/x-kendo-template">

        Got It

    </script>











@endsection



{{--

If create extra update page to edit roles by user need to fetch selected roles from dropdown by following way -

        <div class="form-group">
            <label for="role_title" class="col-sm-2 control-label">Role</label>

            <div class="col-sm-3">
                <select name="role_title[]" id="role_title" class="form-control" multiple="multiple">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}"
                                @foreach($users->roles as $selected) @if($role->id == $selected->id)selected="selected"@endif @endforeach>{{$role->role_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

--}}