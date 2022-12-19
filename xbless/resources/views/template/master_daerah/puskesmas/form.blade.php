@extends('layouts.layout')
@section('title', 'Puskesmas ')
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
                <strong>{{isset($puskesmas) ? 'Edit' : 'Tambah'}} @yield('title')</strong>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($puskesmas)? $enc_id : ''}}">
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Kabupaten</label>
                            <div class="col-sm-9">
                                <div class="input-group ">
                                    <select id="kabupaten" class="select2 form-control chosen-select" name="kabupaten"
                                        @can('kabupaten.index') disabled @endcan>
                                        <option disabled selected value="">Pilih Kabupaten</option>
                                        @foreach($kabupaten as $key => $value)
                                        <option value="{{$value->code_kabupaten}}"
                                            {{$selectedKabupaten==$value->code_kabupaten?'selected':''}}>
                                            {{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    @can('kabupaten.index')
                                    <input type="hidden" name="kabupaten" value="{{$selectedKabupaten}}">
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Kecamatan</label>
                            <div class="col-sm-9">
                                <div class="input-group ">
                                    <select id="kecamatan" class="form-control chosen-select" name="kecamatan">
                                        <option disabled selected value="">Pilih Kecamatan</option>
                                        @if(isset($puskesmas))
                                            @foreach($kecamatan as $key => $value)
                                            <option value="{{ $value->id }}" {{($selectedKecamatan == $value->id) ? 'selected' : ''}}>
                                                {{$value->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Kode Puskesmas</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="code" name="code"
                                        value="{{isset($puskesmas)? $puskesmas->code : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Nama Puskesmas</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="name" name="name"
                                        value="{{isset($puskesmas)? $puskesmas->name : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">address Puskesmas</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <textarea name="address" id="address" cols="30" rows="10"
                                        class="form-control">{{ isset($puskesmas)? $puskesmas->address : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row ">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-sm" href="{{route('master.puskesmas.index')}}">Batal</a>
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
        @can('kabupaten.index')
        var selectedKecamatan = '{{ $selectedKecamatan }}';
            $.ajax({
            url: '{{route("master.puskesmas.kecamatan",[null])}}/' + {{ $selectedKabupaten }},
            type: "GET",
            dataType: "json",
            success:function(data) {
            if(data.jumlah=='0'){
            $('select[name="kecamatan"]').empty();
            }else{
            $('select[name="kecamatan"]').empty();
            $.each(data.data, function(key, value) {
                if(value['id'] == selectedKecamatan){
                    $('select[name="kecamatan"]').append('<option value="'+ value['id'] +'" selected>'+ value['name'] +'</option>');
                }else{
                    $('select[name="kecamatan"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                }
            });
            }
            // console.log(data);
            }
            });

        @endcan
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
                $.each(form, function(idx, val) {
                    dataFile.append(val.name, val.value)
                })
            $.ajax({
                type: 'POST',
                url : "{{route('master.puskesmas.simpan')}}",
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
                        window.location.replace('{{route("master.puskesmas.index")}}');
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

        $('select[name="kabupaten"]').on('change', function() {
            var kabupaten = $(this).val();
            if(kabupaten) {
                $.ajax({
                url: '{{route("master.puskesmas.kecamatan",[null])}}/' + kabupaten,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                    if(data.jumlah=='0'){
                        $('select[name="kecamatan"]').empty();
                    }else{
                        $('select[name="kecamatan"]').empty();
                        $.each(data.data, function(key, value) {
                            $('select[name="kecamatan"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                        });
                    }
                    console.log(data);
                    }
                });
            }
        })
    });
</script>
<script>
</script>
@endpush
