@extends('layouts.layout')
@section('title', 'Kader ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>Master @yield('title')</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{isset($kader) ? 'Edit' : 'Tambah'}} @yield('title')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br />
        <a href="{{ route('master.kader.index') }}"
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
                    <h5>Tambah Kader</h5>
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($kade)? $enc_id : ''}}">
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Nama Kader</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="name" name="name"
                                        value="{{isset($kader)? $kader->name : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">No Telp</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" maxlength="13" class="form-control py-2" id="telp" name="telp"
                                        value="{{isset($kader)? $kader->no_hp : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Kabupaten/Kota *</label>
                            <div class="col-sm-9 error-text">
                                <select class="form-control select2" id="kabupaten" name="kabupaten" {{ (auth()->user()->can('kabupaten.index')) ? 'disabled' : ''}}>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @foreach($kabupaten as $key => $row)
                                        <option name="{{$row->name}}" value="{{$row->id}}"{{ $selectedKabupaten == $row->id ? 'selected=""' : '' }} >{{ucfirst($row->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Kecamatan *</label>
                            <div class="col-sm-9 error-text">
                                <select class="form-control select2" id="kecamatan" name="kecamatan">
                                    @if(isset($kader))
                                        <option value="{{ $kader->kecamatan }}">{{ $kader->kecamatan_name }}</option>
                                    @else
                                        <option value="">Pilih Kecamatan</option>
                                        @can('kabupaten.index')
                                            @foreach($kecamatan as $key => $row)
                                                <option name="{{$row->name}}" value="{{$row->id}}">{{ucfirst($row->name)}}</option>
                                            @endforeach
                                        @endcan
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Puskesmas *</label>
                            <div class="col-sm-9 error-text">
                                <select class="form-control select2" id="puskesmas" name="puskesmas">
                                @if(isset($kader))
                                        <option value="{{ $kader->puskesmas }}">{{ $kader->puskesmas_name }}</option>
                                    @else
                                        <option value="">Pilih Puskesmas</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Posyandu *</label>
                            <div class="col-sm-9 error-text">
                                <select class="form-control select2" id="level" name="level">
                                    <option value="">Pilih Posyandu</option>
                                    @foreach($posyandu as $key => $row)
                                        <option name="{{$row->name}}" value="{{$row->id}}"{{ $selectedPosyandu == $row->id ? 'selected=""' : '' }} >{{ucfirst($row->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Desa</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="desa" name="desa">
                                    <option value="">Pilih Posyandu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">domisili</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <textarea type="text" class="form-control py-2" id="domisili" name="domisili">{{isset($kader)? $kader->domisili : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row ">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-sm" href="{{route('master.kader.index')}}">Batal</a>
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
                kabupaten:{
                    required: true
                },
                kecamatan:{
                    required: true
                },
                puskesmas:{
                    required: true
                },
                posyandu:{
                    required: true
                },
                desa:{
                    required: true
                },
                domisili:{
                    required: true
                },
            },
            messages: {
                name: {
                    required: "nama kader tidak boleh kosong"
                },
                kabupaten:{
                    required: "kabupaten harus dipilih salah satu"
                },
                kecamatan:{
                    required: "kecamatan harus dipilih salah satu"
                },
                puskesmas:{
                    required: "puskesmas harus dipilih salah satu"
                },
                posyandu:{
                    required: "posyandu harus dipilih salah satu"
                },
                desa:{
                    required: "desa tidak boleh kosong"
                },
                domisili:{
                    required: "domisili tidak boleh kosong"
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
                url : "{{route('master.kader.simpan')}}",
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
                        window.location.replace('{{route("master.kader.index")}}');
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
        $('select[name="kabupaten"]').on('change', function() {
            var kabupaten = $(this).val();
            $.ajax({
                url: '{{route("master.kader.puskesmas")}}',
                type: "GET",
                dataType: "json",
                data: {
                    kabupaten: kabupaten
                },
                success:function(data) {
                    $('select[name="puskesmas"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="puskesmas"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                    });
                }
            });
        })

        $('select[name="kabupaten"]').on('change', function() {
            var kabupaten = $(this).val();
            $.ajax({
                url: '{{route("master.kader.kecamatan")}}',
                type: "GET",
                dataType: "json",
                data: {
                    kabupaten: kabupaten
                },
                success:function(data) {
                    $('select[name="kecamatan"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="kecamatan"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                    });
                }
            });
        })

        $('select[name="kecamatan"]').on('change', function() {
            var kecamatan = $(this).val();
            var kabupaten = $('#kabupaten option:selected').val()
            $.ajax({
                url: '{{route("master.kader.puskesmas")}}',
                type: "GET",
                dataType: "json",
                data: {
                    kabupaten: kabupaten,
                    kecamatan: kecamatan
                },
                success:function(data) {
                    $('select[name="puskesmas"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="puskesmas"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                    });
                }
            });
        })

        $('select[name="kecamatan"]').on('change', function() {
            var kecamatan = $(this).val();
            $.ajax({
                url: '{{route("master.kader.desa")}}',
                type: "GET",
                dataType: "json",
                data: {
                    kabupaten: kabupaten
                },
                success:function(data) {
                    $('select[name="desa"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="desa"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                    });
                }
            });
        })

        // $('select[name="kecamatan"]').on('change', function() {
        //     var kecamatan = $(this).val();
        //     var kabupaten = $('#kabupaten option:selected').val()
        //     $.ajax({
        //         url: '{{route("master.kader.puskesmas")}}',
        //         type: "GET",
        //         dataType: "json",
        //         data: {
        //             kabupaten: kabupaten,
        //             kecamatan: kecamatan
        //         },
        //         success:function(data) {
        //             $('select[name="desa"]').empty();
        //             $.each(data, function(key, value) {
        //                 $('select[name="desa"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
        //             });
        //         }
        //     });
        // })
</script>
@endpush
