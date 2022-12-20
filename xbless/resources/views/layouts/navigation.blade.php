<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" width="75px" src="{{ asset('assets/img/user-default.png') }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{auth()->user()->username}}</span>
                        <span class="text-muted text-xs block">{{session('namaakses')}}<b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{route('profil.index')}}">Profil</a></li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{route('manage.logout')}}">
                                Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    PTM
                </div>
            </li>
            <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                <a href="{{ url('/') }}"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span></a>
            </li>

            @can('master.index')
            <li
                class="{{ Route::currentRouteName() === 'staff.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-database"></i> <span class="nav-label">Master</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('staff.index')
                    <li class="{{ Route::currentRouteName() === 'staff.index' ? 'active' : '' }}"><a
                            href="{{route('staff.index')}}">Master User</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('security.index')
            <li
                class="{{Route::currentRouteName() === 'permission.index' || Route::currentRouteName() === 'role.index' ? 'active' : '' }}">
                <a href="#"><i class="fas fa-cogs"></i> <span class="nav-label">Keamanan</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('permission.index')
                    <li class="{{ Route::currentRouteName() === 'permission.index' ? 'active' : '' }}"><a
                            href="{{route('permission.index')}}">Manajemen Modul</a></li>
                    @endcan
                    @can('role.index')
                    <li class="{{ Route::currentRouteName() === 'role.index' ? 'active' : '' }}"><a
                            href="{{route('role.index')}}">Manajemen Akses</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
        </ul>

    </div>
</nav>
