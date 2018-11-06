@extends('layouts.master')
@section('script')
    {!! Html::script('assets/js/permission/permission.js') !!}

    <script type="text/javascript">
        // permissionDetails ();
    </script>
@endsection
@section('title')
    @parent

    | Permission Management
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

    <button type="button" id="insertPermission" class="btn btn-primary" >Add Permission</button>
    <input type="hidden" id="permission_edit_value" value="" >

    {{--<button type="button" id="insertPermission" class="btn btn-primary" data-toggle="modal" data-target="#ModalPermission">Open Modal</button>--}}

    {{--@endcan--}}
    <!-- Modal no need to put tabindex="-1" so that can edit in kendo edit-->

    <div id="ModalPermission" class="modal fade" data-backdrop="static" data-keyboard="false"  role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog  modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Permission</h4>
                </div>
                <div class="modal-body">
                    {!!   Form::open(array(  'method'=>'post', 'id'=>'NewPermissionSave',  'class'=>'form-horizontal inline','files'=> true)) !!}

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


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="close_modal" data-dismiss="modal">Close</button>
                    <button type="reset"  id="clear_modal" onclick="" class="btn btn-default" >Clear</button>
                    <button type="submit" id="save_permission_data" class="btn btn-default"  >Save</button>
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
                @can('Can_Edit')
                    <td>Actions</td>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr>
                    {{--<td><input name="cb[]" type="checkbox" value="{{{ $user->id }}}"></td>--}}

                    <td>{{{ $permission->name }}}</td>

                    <td>{{ $permission->slug }}</td>

                    @can('Can_Edit')
                        <td>
                            <input type='button' class="btn btn-small btn-info" id="edit_button<?php echo $permission->id; ?>" value="Edit" onclick="edit_permission('<?php echo $permission->id; ?>');">
                            <input type='button' class="btn btn-small btn-danger" id="delete_button<?php echo $permission->id; ?>" value="Delete" onclick="delete_permission('<?php echo $permission->id; ?>');">
                        </td>
                    @endcan
                    {{--@endif--}}
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--<div class="pagination"> {!! str_replace('/?', '?', $users->render()) !!}--}}
        {!! Form::close()  !!}

    </div>






    <div id="PermissionGrid">


    </div>

    <script id="template" type="text/x-kendo-template">

        Got It

    </script>











@endsection



