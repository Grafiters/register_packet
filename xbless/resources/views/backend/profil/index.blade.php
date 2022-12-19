@extends('layouts.layout')

@section('title', 'Profile')

@section('content')



<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="fw-600"> @yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> @yield('title')</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row animated fadeInRight">
        <div class="col-md-4">
            <div class="ibox ">
                <div class="ibox-content profile-content widget-head-color-box bg-success p-lg text-center">
                    <img alt="image" class="rounded-circle" width="75px" src="{{ asset('assets/img/user-default.png') }}" />
                    <p class="my-3"><i class="fa fa-map-marker"></i> &nbsp; {{session('namaakses')}}</p>
                </div>
                <div class="ibox-content profile-content feed-activity-list">
                    <p class="feed-element text-center">
                        {{auth()->user()->fullname}}
                    </p>
                    <p class="">
                        <small class="float-right text-danger"> login terakhir
                            : {{auth()->user()->last_login_at}} </small>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="ibox ">
                <div class="ibox-content profile-content widget-head-color-box p-lg">
                    @if(!empty($alert['message']))
                    <div class="alert alert-{{$alert['alert']}}" role="alert">
                        {{ $alert['message'] }}
                    </div>
                    @endif
                    <div class="feed-activity-list">
                        <form class="" role="form" action="{{ route('profil.update') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10 error-text">
                                    <input type="email" class="form-control py-2 rounded" id="email" name="email"
                                        value="{{ isset($profil)? $profil->email : '' }}">
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10 error-text">
                                    <input type="text" class="form-control py-2 rounded" id="phone" name="phone"
                                        value="{{ isset($profil)? $profil->no_hp : '' }}">
                                </div>
                            </div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10 error-text">
                                    <textarea class="form-control col-sm-10 m-0" rows="5"
                                        id="address">{{ isset($profil)? $profil->address : '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10 error-text">
                                    <input type="password" name="password" class="form-control rounded py-2"
                                        required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Confirm New Password</label>
                                <div class="col-sm-10 error-text">
                                    <input type="password2" name="password2" class="form-control pt-2 rounded "
                                        required="">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success full-width m-b ">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
