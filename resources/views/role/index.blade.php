@extends('layouts.master')
@section('script')
    {!! Html::script('assets/js/role/role.js') !!}

    <script type="text/javascript">
        // roleDetails ();
    </script>
@endsection
@section('title')
    @parent

    | Role Management
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



    <!-- Assign With Different Roles Access -->

        {{--@if (auth()->user()->hasRole('root'))--}}
            {{--Hello Root--}}
        {{--@else--}}
            {{--Hello standard user--}}
        {{--@endif--}}



    <!-- Assign With Different Roles Access -->

{{--        @can('Can_Register')--}}
            <!-- Button HTML (to Trigger Modal) -->

        <button type="button" id="insertRole" class="btn btn-primary" >Add Role</button>
        <input type="hidden" id="role_edit_value" value="" >

    {{--<button type="button" id="insertRole" class="btn btn-primary" data-toggle="modal" data-target="#ModalRole">Open Modal</button>--}}

        {{--@endcan--}}
        <!-- Modal no need to put tabindex="-1" so that can edit in kendo edit-->

            <div id="ModalRole" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                <div class="modal-dialog  modal-md">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Role</h4>
                        </div>

                        <div class="modal-body">
                            {!!   Form::open(array(  'method'=>'post', 'id'=>'NewRoleSave',  'class'=>'form-horizontal inline for_edit_role','files'=> true)) !!}

                            {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

                            <div class=" form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-4 control-label">Name</label>

                                <div class="col-sm-6">
                                    <input id="name" required type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class=" form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="slug" class="col-sm-4 control-label">Slug</label>

                                <div class="col-sm-6">
                                    <input id="slug" required type="text" class="form-control" name="slug" value="{{ old('slug') }}" >

                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" id="PermissionCheckboxList" >
                                <label for="permission_name" class=" col-sm-4 control-label">Permission</label>
                                <div class="col-sm-6" >
                                    @foreach($permissions as $permission)
                                        <input type="checkbox" name="permission_name[{{ $permission->id }}]" id="permission_name_{{ $permission->id }}" value="{{ $permission->id }}">
                                        <span>{{ $permission->name }}  </span>

                                    @endforeach
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="permission_name" class="col-sm-4 control-label">Permission</label>--}}

                                {{--<div class="col-sm-6">--}}
                                    {{--<select name="roles" id="roles" class="form-control" >--}}
                                    {{--<select name="permission_name[]" id="permission_name" class="form-control" multiple="multiple">--}}
                                        {{--@foreach($permissions as $permission)--}}
                                            {{--<option value="{{$permission->id}}">{{$permission->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="close_modal" data-dismiss="modal">Close</button>
                            <button type="reset" id="clear_modal" onclick="" class="btn btn-default">Clear</button>
                            <button type="submit" id="save_role_data" onclick="" class="btn btn-default">Save</button>
                        </div>
                        {!! Form::close() !!}
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
            <td>Slug</td>
            <td>Permission</td>
{{--            @can('Can_Edit')--}}
            <td>Actions</td>
            {{--@endcan--}}
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr id="role_row_{{$role->id}}">
                {{--<td><input name="cb[]" type="checkbox" value="{{{ $user->id }}}"></td>--}}

                <td>{{{ $role->name }}}</td>
                <td>{{ $role->slug }}</td>
                <td>
                    @foreach ($role->permissions as $permission)
                        <li>{{ $permission->name }}</li>
                    @endforeach
                </td>

{{--                @can('Can_Edit')--}}
                <td>
                    <input type='button' class="btn btn-small btn-info" id="edit_button<?php echo $role->id; ?>" value="Edit" onclick="edit_role('<?php echo $role->id; ?>');">
                    <input type='button' class="btn btn-small btn-danger" id="delete_button<?php echo $role->id; ?>" value="Delete" onclick="delete_role('<?php echo $role->id; ?>');">
                </td>
                {{--@endcan--}}
                {{--@endif--}}
            </tr>
        @endforeach
        </tbody>
    </table>
    {{--<div class="pagination"> {!! str_replace('/?', '?', $users->render()) !!}--}}
        {!! Form::close()  !!}

    </div>






<div id="RoleGrid">


</div>

<script id="template" type="text/x-kendo-template">

 Got It

</script>











@endsection




{{--

If create extra update page to edit permissions by role need to fetch checked permissions by following way -

<div class="form-group">
    <label for="permission_title" class=" col-sm-2 control-label">Permission</label>

    <div class="col-sm-8">
        @foreach($permissions as $permission)
            <input type="checkbox" name="permission_title[{{ $permission->id }}]" id="{{ $permission->id }}"
                   value="{{ $permission->id }}" {{ $roles->hasPermissions($permission) ? 'checked' : '' }} >
            <span>{{ $permission->permission_title }}  </span>

        @endforeach
    </div>
</div>

--}}