@extends('layouts.layout')
@section('title', 'Speed ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="">Master</a>
            </li>
            <li class="breadcrumb-item">
                <a>Master @yield('title')</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{isset($data) ? 'Edit' : 'Tambah'}} @yield('title')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br />
        <a href="{{ route('admin.master.kategori.speed.index') }}"
            class="btn btn-success btn-hemisperich btn-xs text-white">Kembali</a>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    @if(session('message'))
                    <div class="alert alert-{{session('message')['status']}}">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ session('message')['desc'] }}
                    </div>
                    @endif
                    <h5>{{isset($data) ? 'Edit' : 'Tambah'}} @yield('title')</h5>
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($data)? $enc_id : ''}}">
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Kecepatan Jaringan</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="name" name="name" oninput="this.value=this.value.replace(/[^0-9].[^0-9]/g,'');"
                                        value="{{isset($data)? $data->name : ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-addon">Mbps</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row ">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-sm" href="{{route('admin.master.kategori.speed.index')}}">Batal</a>
                                <button class="btn btn-success btn-sm" type="submit" id="simpan">Simpan</button>
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
<script>
    $(document).ready(function () {
        $('#submitData').validate({
            rules: {
                name:{
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Kecepatan Jaringan tidak boleh kosong"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');

            element.closest('.error-text').append(error);

            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
            Swal.showLoading();
                SimpanData();
            }
        });

        function SimpanData(){
            $('#simpan').addClass("disabled");
            var form = $('#submitData').serializeArray()
            var dataFile = new FormData()
            $.each(form, function(idx, val) {
                dataFile.append(val.name, val.value)
            })
            $.ajax({
                type: 'POST',
                url : "{{route('admin.master.kategori.speed.simpan')}}",
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                data:dataFile,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function () {
                    Swal.showLoading();
                },
                success: function(response){
                    if (response.code == 201) {
                        Swal.fire('Yes',response.message,'info');
                        window.location.replace('{{route("admin.master.kategori.speed.index")}}');
                    } else {
                        Swal.fire('Ups',response.message,'info');
                    }
                    Swal.hideLoading();
                },
                complete: function () {
                    Swal.hideLoading();
                    $('#simpan').removeClass("disabled");
                },
                error: function(response){
                    $('#simpan').removeClass("disabled");
                    Swal.hideLoading();
                    Swal.fire('Ups','Ada kesalahan pada sistem','info');
                    console.log(response);
                }
            });
        }
    });
</script>
@endpush
