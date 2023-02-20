@extends('layouts.layout')
@section('title', 'Detail Register User ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="fw-600"> @yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Master @yield('title')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br />
        <a href="{{ route('admin.register.index') }}"
            class="btn btn-success btn-hemisperich btn-xs text-white">Kembali</a>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form class="px-5">
                        <div class="py-3">
                            {{-- <div class="hr-line-dashed"></div> --}}
                            <h3>Detail User</h3>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">NIK</label>
                                        <div class="col-sm-10">
                                            <div class="input-group error-text">
                                                <input type="text" class="form-control py-2" id="nik" name="nik"
                                                    value="{{ $register->nik }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <div class="input-group error-text">
                                                <input type="text" class="form-control py-2" id="name" name="name"
                                                    value="{{ $register->name }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <div class="input-group error-text">
                                                <input type="text" class="form-control py-2" id="nik" name="nik"
                                                    value="{{ $register->email }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Usaha</label>
                                        <div class="col-sm-10">
                                            <div class="input-group error-text">
                                                <input type="text" class="form-control py-2" id="name" name="name"
                                                    value="{{ $register->usaha }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Contact 1</label>
                                        <div class="col-sm-10">
                                            <div class="input-group error-text">
                                                <input type="text" class="form-control py-2" id="nik" name="nik"
                                                    value="{{ $register->contact[0]->contact }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Contact 2</label>
                                        <div class="col-sm-10">
                                            <div class="input-group error-text">
                                                <input type="text" class="form-control py-2" id="name" name="name"
                                                    value="{{ $register->contact[1]->contact }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Alamat</label>
                                        <div class="col-sm-11 error-text">
                                            {{-- <div class="input-group error-text"> --}}
                                                <textarea name="" id="" class="form-control" cols="10" style="font-size: 12px;" disabled>{{ $register->address }}</textarea>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Note</label>
                                        <div class="col-sm-11 error-text">
                                            {{-- <div class="input-group error-text"> --}}
                                                <textarea name="" id="" class="form-control" cols="10" style="font-size: 12px;" disabled>{{ $register->note }}</textarea>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <h3>Image User</h3>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                @foreach($register->img as $key => $value)
                                    <div class="col-md-4" style="padding-bottom: 15px;">
                                        <div class="card" style="box-shadow: 0px 2px 15px rgba(18, 66, 101, 0.08); border:none;">
                                            <img class="card-img-top mx-auto d-flex" src="{{ asset($value->img) }}" alt="{{ $value->name }}" style="width: auto; height: 15rem; justify-content: center; padding-top: 15px;">
                                            <hr>
                                            <div class="card-body">
                                                <p class="card-text text-center" style="padding-bottom: 15px;">
                                                    {{ $value->fullname }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush