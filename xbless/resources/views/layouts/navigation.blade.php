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
                class="{{ Route::currentRouteName() === 'staff.index' || Route::currentRouteName() === 'master.provinsi.index' ||Route::currentRouteName() === 'master.kabupaten.index' || Route::currentRouteName() === 'master.kecamatan.index' || Route::currentRouteName() === 'master.puskesmas.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-database"></i> <span class="nav-label">Master</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('staff.index')
                    <li class="{{ Route::currentRouteName() === 'staff.index' ? 'active' : '' }}"><a
                            href="{{route('staff.index')}}">Master User</a></li>
                    @endcan
                    @can('master.provinsi.index')
                    <li class="{{ Route::currentRouteName() === 'master.provinsi.index' ? 'active' : '' }}"><a
                            href="{{route('master.provinsi.index')}}">Master Provinsi</a></li>
                    @endcan
                    @can('master.kabupaten.index')
                    <li class="{{ Route::currentRouteName() === 'master.kabupaten.index' ? 'active' : '' }}"><a
                            href="{{route('master.kabupaten.index')}}">Master Kabupaten</a></li>
                    @endcan
                    @can('master.kecamatan.index')
                    <li class="{{ Route::currentRouteName() === 'master.kecamatan.index' ? 'active' : '' }}"><a
                            href="{{route('master.kecamatan.index')}}">Master Kecamatan</a></li>
                    @endcan
                    @can('master.puskesmas.index')
                    <li class="{{ Route::currentRouteName() === 'master.puskesmas.index' ? 'active' : '' }}"><a
                            href="{{route('master.puskesmas.index')}}">Master Puskesmas</a></li>
                    @endcan
                    @can('master.desa.index')
                    <li class="{{ Route::currentRouteName() === 'master.desa.index' ? 'active' : '' }}"><a
                            href="{{route('master.desa.index')}}">Master Desa</a></li>
                    @endcan
                    @can('master.kader.index')
                    <li class="{{ Route::currentRouteName() === 'master.kader.index' ? 'active' : '' }}"><a
                            href="{{route('master.kader.index')}}">Master Kader</a></li>
                    @endcan
                    @can('master.kadin.index')
                    <li class="{{ Route::currentRouteName() === 'master.kabid.index' ? 'active' : '' }}"><a
                            href="{{route('master.kabid.index')}}">Master Kepala Bidang</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('certificate.index')
            <li
                class="{{ Route::currentRouteName() === 'certificate.index' || Route::currentRouteName() === 'certificate.generate.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-certificate"></i> <span class="nav-label">Sertifikat</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('certificate.generate.index')
                    <li class="{{ Route::currentRouteName() === 'certificate.generate.index' ? 'active' : '' }}"><a
                            href="{{route('certificate.generate.index')}}">Sertifikat</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('laporan.index')
            <li
                class="{{ Route::currentRouteName() === 'laporan.index' || Route::currentRouteName() === 'laporan.generate.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-list"></i> <span class="nav-label">Laporan</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('laporan.certificate.index')
                    <li class="{{ Route::currentRouteName() === 'laporan.certificate.index' ? 'active' : '' }}"><a
                            href="{{route('laporan.index')}}">Rekap</a></li>
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
