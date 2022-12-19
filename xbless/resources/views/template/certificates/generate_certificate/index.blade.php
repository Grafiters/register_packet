@extends('layouts.layout')

@section('title', 'Sertifikat ')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sertifikat</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('manage.beranda')}}">Beranda</a>
            </li>
            <li class="breadcrumb-item active">
                <a>Sertifikat</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <br />
        @can('certificate.generate.tambah')
        <a href="{{ route('certificate.generate.tambah')}}" class="btn btn-success"><span class="fa fa-pencil-square-o"></span>&nbsp;
            Tambah</a>
        @endcan
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                      <div class="form-group row" style="margin-left:5px;">
                          <label class="col-sm-2 col-form-label">KABUPATEN :</label>
                          <div class="col-sm-3 error-text">
                              <select class="form-control" id="kabupaten" name="kabupaten">
                                 <option value="all">Semua Kabupaten</option>
                                  @foreach($kabupaten as $key => $row)
                                      <option value="{{$row->id}}">{{$row->name}}</option>
                                  @endforeach
                              </select>
                          </div>

                          <label class="col-sm-2 col-form-label">PUSKESMAS :</label>
                          <div class="col-sm-3 error-text">
                              <select class="form-control" id="puskesmas" name="puskesmas">
                                 <option value="all">Semua Puskesmas</option>
                                  @foreach($puskesmas as $key => $row)
                                      <option value="{{$row->id}}">{{$row->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group row" style="margin-left:5px;">
                          <label class="col-sm-2 col-form-label">POSYANDU :</label>
                          <div class="col-sm-3 error-text">
                              <select class="form-control" id="posyandu" name="posyandu">
                                 <option value="all">Semua Posyandu</option>
                                  @foreach($posyandu as $key => $row)
                                      <option value="{{$row->id}}">{{$row->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6 error-text">
                           <button class="btn btn-success" id="cariData" type="button"><span class="fa fa-search"></span>&nbsp; Cari Data</button>
                        </div>
                      </div>
                      <form id="frm-sertif" action="{{ route('certificate.generate.cetakall') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <p class="text-right">
                            <button type="submit" name="cetakan" value="pdf" class="btn btn-primary b-r-l px-3 my-2"><i class="fa fa-file-pdf"></i>
                                &nbsp;
                                Cetak Pdf</button>
                        </p>
                        <table id="table1" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    @can('provinsi.index')
                                    <th>Kabupaten</th>
                                    @endcan
                                    @can('kabupaten.index')
                                    <th>Kecamatan</th>
                                    @endcan
                                    <th>Puskesmas</th>
                                    <th>Kader</th>
                                    <th>Posyandu</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                      </form>
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
           $('#kabupaten').select2({
              ajax: {
                  url: '{{route('master.kabupaten.getselect')}}',
                  dataType: 'json',
                  data: function (params) {
                      return {
                          term: params.term,
                      }
                  }
              }
          });
          $('#puskesmas').select2({
        //       ajax: {
        //           url: '{{route('master.puskesmas.getselect')}}',
        //           dataType: 'json',
        //           data: function (params) {
        //               return {
        //                   term: params.term,
        //               }
        //           }
        //       }
          });
           $.ajaxSetup({
               headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
           });
           table= $('#table1').DataTable({
           "processing": true,
           "serverSide": true,
          //  "stateSave"  : true,
          //  "deferRender": true,
           "pageLength": 25,
           "select" : true,
           "ajax":{
                    "url": "{{ route("certificate.generate.getdata") }}",
                    "dataType": "json",
                    "type": "POST",
                    data: function ( d ) {
                      d._token= "{{csrf_token()}}";
                      d.filter_kabupaten = $('#kabupaten').val();
                      d.filter_puskesmas = $('#puskesmas').val();
                      d.filter_posyandu = $('#posyandu').val();
                    }
                  },
            "columnDefs": [
               {
                  "targets": 0,
                  "checkboxes": {
                     "selectRow": true
                  }
               }
            ],
            "select": {
               "style": "multi"
            },
           "columns": [

               {
                 "data": "no",
                 "orderable" : false,
               },
               { "data": "kabupaten"},
               { "data": "puskesmas"},
               { "data": "kader"},
               { "data": "posyandu" },
               { "data" : "action",
                 "orderable" : false,
                 "className" : "text-center",
               },
           ],
           responsive: true,
           language: {
               search: "_INPUT_",
               searchPlaceholder: "Cari data",
               emptyTable: "Belum ada data",
               info: "Menampilkan data _START_ sampai _END_ dari _MAX_ data.",
               infoEmpty: "Menampilkan 0 sampai 0 dari 0 data.",
               lengthMenu: "Tampilkan _MENU_ data per halaman",
               loadingRecords: "Loading...",
               processing: "Mencari...",
               paginate: {
                 "first": "Pertama",
                 "last": "Terakhir",
                 "next": "Sesudah",
                 "previous": "Sebelum"
               },
           }
         });
         tabledata = $('#orderData').DataTable({
           dom     : 'lrtp',
           paging    : false,
           columnDefs: [ {
                 "targets": 'no-sort',
                 "orderable": false,
           } ]
         });
         $('#filter').click(function(){
             table.ajax.reload(null, false);

         });
         $('#cariData').on('click', function() {
             table.ajax.reload(null, false);
         });
         table.on('select', function ( e, dt, type, indexes ){
           table_index = indexes;
           var rowData = table.rows( indexes ).data().toArray();

         });

         // Handle form submission event
         $('#frm-sertif').on('submit', function(e){
            var form = this;

            var rows_selected = table.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId){
              var rowData = table.rows( index ).data().toArray();
               // Create a hidden element
               $(form).append(
                   $('<input>')
                      .attr('type', 'hidden')
                      .attr('name', 'id_sertif[]')
                      .val(rowData[0]['id'])
               );
            });

         });

       });


         function deleteStaff(e,enc_id){
           @cannot('staff.hapus')
               Swal.fire('Ups!', "Anda tidak memiliki HAK AKSES! Hubungi ADMIN Anda.",'error'); return false;
           @else
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
           if (result.value) {
             $.ajaxSetup({
               headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
             });
              $.ajax({
               type: 'DELETE',
               url: '{{route("staff.hapus",[null])}}/' + enc_id,
               headers: {'X-CSRF-TOKEN': token},
               success: function(data){
                 if (data.status=='success') {
                     Swal.fire('Yes',data.message,'success');
                     table.ajax.reload(null, true);
                  }else{
                    Swal.fire('Ups',data.message,'info');
                  }
               },
               error: function(data){
                 console.log(data);
                 Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
               }
             });


           } else {

           }
          });
           @endcannot
       }
       $(document.body).on("keydown", function(e){
         ele = document.activeElement;
           if(e.keyCode==38){
             table.row(table_index).deselect();
             table.row(table_index-1).select();
           }
           else if(e.keyCode==40){

             table.row(table_index).deselect();
             table.rows(parseInt(table_index)+1).select();
             console.log(parseInt(table_index)+1);

           }
           else if(e.keyCode==13){

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
</script>
<script>
    function resetpwd(id){
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Password akan tereset!",

            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya",
            cancelButtonText:"Batal",
            confirmButtonColor: "#ec6c62",
            closeOnConfirm: false
        }).then(function(result){
            if(result.value){
                $.ajax({
                   type: 'GET',
                   url : "{{route('staff.resetpwd', [NULL])}}/"+id,
                   // headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                   processData: false,
                   contentType: false,
                   dataType: "json",
                   beforeSend: function () {
                       Swal.showLoading();
                   },
                   success: function(data){
                       if (data.success == true) {
                           Swal.fire('Yes',data.message,'info');
                           window.location.replace('{{route("staff.index")}}');
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
        })
     }
</script>
@endpush
