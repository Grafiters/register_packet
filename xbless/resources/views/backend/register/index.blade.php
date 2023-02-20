@extends('layouts.layout')
@section('title', 'Register User ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="fw-600"> @yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
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
                        {{-- <a href="{{ route('admin.')}}" class="btn btn-success rounded-0"> Tambah </a> --}}
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="table1" class="table p-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nik</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Paket</th>
                                    <th>Usaha</th>
                                    <th>Alamat</th>
                                    <th>Note</th>
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

<div class="modal inmodal fade" id="modal_img" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modal_content">
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    var table,tabledata,table_index;
    $(document).ready(function(){
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
                     "url": "{{ route("admin.register.getdata") }}",
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
                { "data": "nik"},
                { "data": "name"},
                { "data": "email"},
                { "data": "contact"},
                { "data": "code"},
                { "data": "usaha"},
                { "data": "address"},
                { "data": "note"},
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

    function detailImg(e, id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'get',
            url: '{{route("admin.register.detail_img",[null])}}/' + id,
            headers: {'X-CSRF-TOKEN': token},
            success: function(response){
                if(response.code == 200){
                    $('#modal_content').empty()
                    const parent = document.createElement('div');
                    $(parent).addClass('modal-header')
                    const title = document.createElement('h3')
                    $(title).text('Detail Image')
                    $(parent).append(title)
                    $('#modal_content').append(parent)

                    const content = document.createElement('div')
                    $(content).addClass('modal-body')
                    const detail = document.createElement('div')
                    $(detail).addClass('row')
                    $('#modal_content').append(content)
                    var image = response.data.img.map(function(value, index){
                        const size_card_img = document.createElement('div')
                        $(size_card_img).addClass('col col-md-4')
                        $(size_card_img).attr('style', 'padding: 10px;')
                        const img_content = document.createElement('div')
                        $(img_content).addClass('card')
                        $(img_content).attr('style','box-shadow: 0px 2px 15px rgba(18, 66, 101, 0.08); border: none;')
                        
                        const img_data = document.createElement('img')
                        $(img_data).addClass('card-img-top mx-auto d-flex')
                        const src = `{{ asset('${value.img}') }}`
                        $(img_data).attr('src', src)
                        $(img_data).attr('style', 'width: auto; height: 15rem; justify-content: center; padding-top: 15px;')
                        $(img_content).append(img_data)

                        const separator = document.createElement('hr')
                        $(img_content).append(separator)
                        
                        const card_body = document.createElement('div')
                        $(card_body).addClass('card-body')
                        const img_text = document.createElement('p')
                        $(img_text).addClass('card-text text-center')
                        $(img_text).attr('style', 'padding-bottom: 15px;')
                        $(img_text).text(`${value.fullname}`)
                        $(card_body).append(img_text)
                        $(img_content).append(card_body)

                        $(size_card_img).append(img_content)
                        $(detail).append(size_card_img)
                    })

                    $(content).append(detail)
                    const footer = document.createElement('div')
                    $(footer).addClass('modal-footer')
                    const close = document.createElement('button')
                    $(close).addClass('btn btn-md btn-danger')
                    $(close).attr('data-dismiss', 'modal')
                    $(close).text('Close')
                    $(footer).append(close)
                    $('#modal_content').append(footer)

                    $('#modal_img').modal('show')
                }else{
                    Swal.fire('Ups',response.message,'info');
                }
            }
        })
    }
</script>
@endpush