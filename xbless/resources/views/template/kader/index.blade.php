@extends('layouts.layout')
@section('title', 'Kader')
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
                            {{ session('message')['desc'] }}
                        </div>
                    @endif
                    <div class="row">
                        @if($kabupaten)
                        <div class="col-md-4">
                            <label class="col-form-label">Kabupaten/Kota</label>
                            <select class="form-control select2" id="kabupaten" name="kabupaten">
                                <option value="">Pilih Kabupaten/Kota</option>
                                @foreach($kabupatendata as $key => $row)
                                    <option name="{{$row->name}}" value="{{$row->id}}">{{ucfirst($row->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if($kecamatan)
                        <div class="col-md-4">
                            <label class="col-form-label">Kecamatan</label>
                            <select class="form-control select2" id="kecamatan" name="kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                @if(!$kabupaten)
                                    @foreach($kecamatandata as $key => $row)
                                        <option name="{{$row->name}}" value="{{$row->id}}">{{ucfirst($row->name)}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @endif
                        @if($posyandu)
                        <div class="col-md-4">
                            <label class="col-form-label">Puskesmas</label>
                            <select class="form-control select2" id="puskesmas" name="puskesmas">
                                <option value="">Pilih Puskesmas</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content p-5">
                    <div class="d-flex">
                        <a href="{{ route('master.kader.tambah')}}" class="btn btn-success rounded-0"> Tambah </a>
                        <a href="javascript:void(0);"
                            class="btn text-dark rounded-0 border border-secondary btn-refresh">Refresh</a>
                        <a href="{{ route('master.kader.import')}}" class="btn btn-primary rounded-0"> Import </a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="table1" class="table p-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if(auth()->user()->can('provinsi.index'))
                                    <th>Kabupaten</th>
                                    @elseif(auth()->user()->can('kabupaten.index'))
                                    <th>Kecamatan</th>
                                    @else
                                    <th>Kabupaten</th>
                                    @endif
                                    <th>Nama Kader</th>
                                    <th>Puskesmas</th>
                                    <th>Posyandu</th>
                                    <th>Desa</th>
                                    <th>Domisili</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    var table,tabledata,table_index;
    $(document).ready(function(){
        $('.select2').select2()
        $(".btn-refresh").click(function() {
            table.ajax.reload();
        });
        $.ajaxSetup({
            headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
        });
        table = $('#table1').DataTable({
            "pagingType": "full_numbers",
            pageLength: 25,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "select" : true,
            "ajax":{
                     "url": "{{ route("master.kader.getdata") }}",
                     "dataType": "json",
                     "type": "POST",
                     data: function ( d ) {
                       d._token= "{{csrf_token()}}";
                       d.kabupaten=$('#kabupaten option:selected').val()
                       d.kecamatan=$('#kecamatan option:selected').val()
                     }
                   },
            "columns": [
                {
                  "data": "no",
                  "orderable" : false,
                },
                { "data": "kabupaten"},
                { "data": "name"},
                { "data": "puskesmas"},
                { "data": "posyandu"},
                { "data": "desa"},
                { "data": "domisili"},
                { "data" : "action",
                  "orderable" : false,
                  "className" : "text-right",
                },
            ],
            responsive: true,
            language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data",
            },
        });
    });

    $(document).on('change', '#kabupaten', function(){
        table.ajax.reload()
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

    $(document).on('change', '#kecamatan', function(){
        table.ajax.reload()
        var kabupaten = $('#kabupaten option:selected').val();
        $.ajax({
            url: '{{route("master.kader.puskesmas")}}',
            type: "GET",
            dataType: "json",
            data: {
                kabupaten: kabupaten,
                kecamatan: $(this).val()
            },
            success:function(data) {
                $('select[name="puskesmas"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="puskesmas"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                });
            }
        });
    })

    function deleteData(e,enc_id){
        var token = '{{ csrf_token() }}';
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data akan terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya",
            cancelButtonText:"Batal",
            confirmButtonColor: "#ec6c62",
            closeOnConfirm: false
        }).then(function(result) {
            console.log(result)
            if (result.value) {
                $.ajaxSetup({
                    headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
                });
                $.ajax({
                    type: 'delete',
                    url: '{{route("master.kader.hapus",[null])}}/' + enc_id,
                    headers: {'X-CSRF-TOKEN': token},
                    success: function(data){
                    console.log(data)
                    if (data.status == 'success') {
                        Swal.fire('Yes',data.message,'success');
                        table.ajax.reload(null, true);
                    }else{
                        Swal.fire('Ups',data.message,'info');
                    }
                },
                error: function(data){
                    console.log(data);
                    Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                }});
            }
        });
    }
</script>
@endpush
