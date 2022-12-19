@extends('layouts.layout')

@section('title', 'Sertifikat ')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{isset($staff) ? 'Edit' : 'Tambah'}} Sertifikat</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('manage.beranda')}}">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('certificate.generate.index')}}">Master Sertifikat</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{isset($staff) ? 'Edit' : 'Tambah'}}</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br/>
        <a class="btn btn-white btn-sm" href="{{route('staff.index')}}">Batal</a>
    </div>
</div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        @if(session('message'))
                            <div class="alert alert-{{session('message')['status']}}">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ session('message')['desc'] }}
                            </div>
                        @endif

                    </div>
                    <div class="ibox-content">
                        <form id="submitData">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="enc_id" id="enc_id" value="{{isset($staff)? $enc_id : ''}}">
                            <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Kabupaten/Kota *</label>
                                <div class="col-sm-9 error-text">
                                    <select class="form-control select2" id="kabupaten" name="kabupaten">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        @foreach($kabupaten as $key => $row)
                                            <option name="{{$row->name}}" value="{{$row->id}}"{{ $selectedKabupaten == $row->id ? 'selected=""' : '' }} >{{ucfirst($row->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Puskesmas *</label>
                                <div class="col-sm-9 error-text">
                                    <select class="form-control select2" id="level" name="level">
                                        <option value="">Pilih Puskesmas</option>
                                        @foreach($puskesmas as $key => $row)
                                            <option name="{{$row->name}}" value="{{$row->id}}"{{ $selectedPuskesmas == $row->id ? 'selected=""' : '' }} >{{ucfirst($row->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Kader *</label>
                                <div class="col-sm-9 error-text">
                                    <select class="form-control select2" id="kader" name="kader">
                                        <option value="">Pilih Kader</option>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row px-4"><label class="col-sm-3 col-form-label">Pilih Posyandu *</label>
                                <div class="col-sm-9 error-text">
                                    <select class="form-control select2" id="posyandu" name="posyandu">
                                        <option value="">Pilih Posyandu</option>
                                        @foreach($posyandu as $key => $row)
                                            <option name="{{$row->name}}" value="{{$row->id}}"{{ $selectedPosyandu == $row->id ? 'selected=""' : '' }} >{{ucfirst($row->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white btn-sm" href="{{route('certificate.generate.index')}}">Batal</a>
                                    <button class="btn btn-primary btn-sm" type="submit" id="simpan">Simpan</button>
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
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('#submitData').validate({
            rules: {
              level:{
                  required: true,
              },
              posyandu:{
                  required: true,
              },
            },
            messages: {
              level: {
                  required: "Pilih salah satu"
              },
              posyandu: {
                  required: "Pilih salah satu"
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
          url : "{{route('certificate.generate.simpan')}}",
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
               window.location.replace('{{route("certificate.generate.index")}}');
            } else {
               Swal.fire('Ups',data.message,'info');
            }
          },
          complete: function () {
             Swal.hideLoading();
            $('#simpan').removeClass("disabled");
          },
          error: function(data){
            $('#simpan').removeClass("disabled");
             Swal.hideLoading();
            console.log(data);
          }
        });
    }

    });
    function removeSpaces(string) {
     return string.split(' ').join('');
    }
</script>
<script>
    $(".select2").select2()

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
                $('select[name="level"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="level"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                });
            }
        });
    })

    $('select[name="level"]').on('change', function() {
        var puskesmas = $(this).val();
        var kabupaten = $('#kabupaten option:selected').val()
        $.ajax({
            url: '{{route("certificate.generate.kader")}}',
            type: "GET",    
            dataType: "json",
            data: {
                kabupaten: kabupaten,
                puskesmas: puskesmas
            },
            success:function(data) {
                $('#kader').empty();
                $('#kader').append('<option value="">Pilih Kader</option>');
                $.each(data, function(key, value) {
                    $('#kader').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                });
            }
        });
    })

</script>
@endpush
