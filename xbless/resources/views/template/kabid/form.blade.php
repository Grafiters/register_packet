@extends('layouts.layout')
@section('title', 'Kepala Dinas ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="">Master</a>
            </li>
            <li class="breadcrumb-item">
                <a>Master @yield('title')</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{isset($kabid) ? 'Edit' : 'Tambah'}} @yield('title')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br />
        <a href="{{ route('master.puskesmas.index') }}"
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
                    <h5>Tambah Puskesmas</h5>
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($kabid)? $enc_id : ''}}">
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">NIP</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="nip" name="nip"
                                        value="{{isset($kabid)? $kabid->nip : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="name" name="name"
                                        value="{{isset($kabid)? $kabid->name : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Pangkat</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="pangkat" name="pangkat"
                                        value="{{isset($kabid)? $kabid->tingkatan : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Gambar Product</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="custom-file">
                                    <input type="file" class="form-control custom-file-input" id="inputGroupFile01" name="img">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select id="status" class="form-control select2" name="status">
                                    <option value="0">Tidak Aktif</option>
                                    <option value="1" selected>Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row ">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-sm" href="{{route('master.kabid.index')}}">Batal</a>
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
        $('.select2').select2()
        $('#submitData').validate({
            rules: {
                name:{
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Nama Departemen tidak boleh kosong"
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
                var image = document.querySelector('input[name=img]')
                file = image.files[0]
                $.each(form, function(idx, val) {
                    dataFile.append(val.name, val.value)
                    dataFile.append("img", file)
                })
            $.ajax({
                type: 'POST',
                url : "{{route('master.kabid.simpan')}}",
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                data:dataFile,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function () {
                    Swal.showLoading();
                },
                success: function(data){
                    if (data.success) {
                        Swal.fire('Yes',data.message,'info');
                        window.location.replace('{{route("master.kabid.index")}}');
                    } else {
                        Swal.fire('Ups',data.message,'info');
                    }
                    Swal.hideLoading();
                },
                complete: function () {
                    Swal.hideLoading();
                    $('#simpan').removeClass("disabled");
                },
                error: function(data){
                    $('#simpan').removeClass("disabled");
                    Swal.hideLoading();
                    Swal.fire('Ups','Ada kesalahan pada sistem','info');
                    console.log(data);
                }
            });
        }
    });
</script>
<script>
</script>
@endpush
