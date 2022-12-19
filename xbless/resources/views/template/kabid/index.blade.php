@extends('layouts.layout')
@section('title', 'Kepala Dinas')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="fw-600"> @yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="">Master</a>
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
                    <div class="d-flex">
                        <a href="{{ route('master.kabid.tambah')}}" class="btn btn-success rounded-0"> Tambah </a>
                        <a href="javascript:void(0);"
                            class="btn text-dark rounded-0 border border-secondary btn-refresh">Refresh</a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="table1" class="table p-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Pangkat</th>
                                    <th>Status</th>
                                    <th>Tanda Tangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "select" : true,
            "ajax":{
                     "url": "{{ route("master.kabid.getdata") }}",
                     "dataType": "json",
                     "type": "POST",
                     data: function ( d ) {
                       d._token= "{{csrf_token()}}";
                     }
                   },
            "columns": [
                {
                  "data": "no",
                  "orderable" : false,
                },
                {"data": "nip"},
                {"data": "name"},
                {"data": "tingkatan"},
                {"data": "status"},
                {"data" : "img",
                    "render": function(data, type, row){
                        if(data == '-'){
                            return '-'
                        }else{
                            return '<img src="'+data+'" width="100" class = "img-thumbnail"/>'
                        }
                    }
                },
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
        $('#periode_bln .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
        });
        $("#select_kab").select2({
            placeholder: "Pilih Kabupaten .....",
            allowClear: true
        });
        $("#select_pusk").select2({
            placeholder: "Pilih Puskesmas .....",
            allowClear: true
        });
    });

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
                    url: '{{route("master.puskesmas.hapus",[null])}}/' + enc_id,
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
