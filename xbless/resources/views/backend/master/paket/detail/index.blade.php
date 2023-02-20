@extends('layouts.layout')
@section('title', 'Paket')
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
                        <a href="{{ route('admin.master.paket.detail.tambah')}}" class="btn btn-success rounded-0"> Tambah </a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="table1" class="table p-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Kecepatan</th>
                                    <th>Harga</th>
                                    <th>status</th>
                                    <th>Benefit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "select" : true,
            "ajax":{
                     "url": "{{ route("admin.master.paket.detail.getdata") }}",
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
                { "data": "paket"},
                { "data": "speed"},
                { "data": "price"},
                { "data": "status"},
                { "data": "description"},
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
                    url: '{{route("admin.master.paket.detail.hapus",[null])}}/' + enc_id,
                    headers: {'X-CSRF-TOKEN': token},
                    success: function(response){
                    if (response.code == 201) {
                        Swal.fire('Yes',response.message,'success');
                        table.ajax.reload(null, true);
                    }else{
                        Swal.fire('Ups',response.message,'info');
                    }
                },
                error: function(response){;
                    Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                }});
            }
        });
    }
</script>
@endpush
