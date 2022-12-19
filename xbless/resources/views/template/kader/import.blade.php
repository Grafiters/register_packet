@extends('layouts.layout')
@section('title', 'Import Kader')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="fw-600"> @yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="">Kasus</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Master @yield('title')</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content p-5">
                    @if(session('message'))
                        <div class="alert alert-{{session('message')['status']}}">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <p>{!! session('message')['jmlData'] !!}</p>
                            <p>{!! session('message')['sukses'] !!}</p>
                            <p>{!! session('message')['gagal'] !!}</p>
                            <p>{!! session('message')['descGagal'] !!}</p>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <label for="kader" class="control-label"><h3>Import Data Kader</h3></label>
                        </div>
                        <div class="col-md-6">
                            <div class="import text-right">
                                <a href="{{ asset('assets/import/template_import_kader.xlsx') }}" class="btn btn-success icon-btn md-btn-flat product-tooltip float-end" download="template_import_kader" download><i class="fa fa-download"></i> Download Template</a>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <form class="form-horizontal" id="submitData" method="POST" action="{{route('master.kader.simpanimport')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-grouprow">
                            
                            <input type="file" class="form-control" name="file" value=""/>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
