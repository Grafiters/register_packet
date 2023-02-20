@extends('layouts.layout')
@section('title', 'Paket ')
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
                            <label class="col-sm-3 col-form-label">Jenis Paket</label>
                            <div class="col-sm-9">
                                <select name="paket" id="paket" class="form-control select2">
                                    <option value="">Pilih Jenis Paket</option>
                                    @foreach ($paket as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Kecepatan Jaringan</label>
                            <div class="col-sm-9">
                                <select name="speed" id="speed" class="form-control select2">
                                    <option value="">Pilih Kecepatan</option>
                                    @foreach ($speed as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <div class="input-group error-text">
                                    <div class="input-group-append">
                                        <span class="input-group-addon">Rp</span>
                                    </div>
                                    <input type="text" class="form-control py-2" id="harga" name="harga"
                                        value="{{isset($data)? $data->price : ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-addon">/ Bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-4">
                            <label class="col-sm-3 col-form-label">Benefit</label>
                            <div class="col-sm-9">
                                <div class="input-group no-padding error-text">
                                    <textarea class="summernote form-control" name="benefit">
                                        
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row ">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-white btn-sm" href="{{route('admin.master.kategori.paket.index')}}">Batal</a>
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
        $('textarea').summernote({
            width: '100%',
            height: 100,
        });
        $('.select2').select2()
        $('#submitData').validate({
            rules: {
                name:{
                    required: true
                },
                detail:{
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Nama Paket tidak boleh kosong"
                },
                detail:{
                    required: "Detail Paket tidak boleh kosong"
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
                url : "{{route('admin.master.paket.detail.simpan')}}",
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
                        window.location.replace('{{route("admin.master.kategori.paket.index")}}');
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

    $(document).on('keyup', '#harga', function(){
        var value = Number(this.value.replace(/\./g, ""));
        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        value = formatRupiah(this.value, '');
        var nilai = this.value.replace(/\./g, "");
        if(!numberRegex.test(nilai)){
            $('#harga').val('');
            return false;
        }

        if(value.charAt(0) > 0){
            $('#harga').val(formatCurrent(nilai));
        }else{
            if(value.charAt(1) == '0'){
                $('#harga').val(0);
            }else{
                $('#harga').val(formatCurrent(value));
            }
        }
    })

    function formatCurrent(nStr){
        nStr+='';
        x=nStr.split('.');
        x1=x[0];
        x2=x.length>1?'.'+x[1]:'';
        var rgx = /(\d+)(\d{3})/;
        while(rgx.test(x1)){
            x1=x1.replace(rgx,'$1'+'.'+'$2');
        }
        return x1+x2;
    }

    function formatRupiah(angka,prefix){
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }
</script>
@endpush
