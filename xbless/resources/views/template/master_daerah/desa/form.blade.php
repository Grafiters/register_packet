@extends('layouts.layout')
@section('title', 'Desa ')
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
                <strong>{{isset($desa) ? 'Edit' : 'Tambah'}} @yield('title')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br />
        <a href="{{ route('master.desa.index') }}"
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
                    <h5>Tambah Desa</h5>
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($desa)? $enc_id : ''}}">
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Kabupaten</label>
                            <div class="col-sm-9">
                                <select id="kabupaten" class="select2 form-control" name="kabupaten">
                                    <option disabled selected value="">Pilih Kabupaten</option>
                                    @foreach($kabupaten as $key => $value)
                                    <option value="{{$value->code_kabupaten}}"
                                        {{$selectedKabupaten==$value->code_kabupaten?'selected':''}}>
                                        {{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Kecamatan</label>
                            <div class="col-sm-9">
                                <select id="kecamatan" class="form-control select2" name="kecamatan">
                                    <option value="">Pilih Kecamatan</option>
                                    @if($desa)
                                        <option selected value="{{ $desa->kecamatan_id }}">{{ ucfirst($desa->kecamatan) }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Code Desa</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="code" name="code"
                                        value="{{isset($desa)? $desa->id : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Nama Desa</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <input type="text" class="form-control py-2" id="name" name="name"
                                        value="{{isset($desa)? $desa->name : ''}}">
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
                $.each(form, function(idx, val) {
                    dataFile.append(val.name, val.value)
                })
            $.ajax({
                type: 'POST',
                url : "{{route('master.desa.simpan')}}",
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
                        window.location.replace('{{route("master.desa.index")}}');
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
