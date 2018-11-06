{{--@extends('layouts.header')--}}
<body>
<script type="text/javascript">

    // window.onload=function(){
    // document.getElementById("acl_list").addEventListener("click", aclDetails);
    // }
</script>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="/podrec">
                    PODREC
                </a>

            </li>
            {{--    <input type="hidden" id="user_register_token" name="user_register_token" value="{{Auth::user()->register_token}}"  />--}}

            <li>
                @guest

                    Welcome
                @else
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                           aria-haspopup="true">
                            Welcome {{ Auth::user()->name }}
                        </a>
                @endguest
            </li>
            <li>
                <a href="{{{url('outbound')}}}">Outbound</a>
            </li>
            <li>
                <a href="#">Inbound</a>
            </li>
{{--            @can('Can_Register')--}}
            <li>
                <a href="{{{url('user')}}}">User</a>
            </li>

            <li>
                <a href="{{{url('role')}}}">Role</a>
            </li>
            <li>
                <a href="{{{url('permission')}}}">Permission</a>
            </li>
            <li>
                <a id="" href="{{{url('acl')}}}">ACL List</a>
            </li>
            {{--@endcan--}}
            <li>
                @guest
                <a href="{{{url('login')}}}">Sign In</a>
                @endguest
            </li>

            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    Sign Out
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
            @yield('sidebar')

        </ul>

    </div>
    <!-- /#sidebar-wrapper -->
