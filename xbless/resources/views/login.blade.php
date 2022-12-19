<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{__('menu_wording.title')}} | Login</title>

    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

    {{-- favicon --}}
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">

    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/login.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('assets/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('assets/js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{ asset('assets/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">

</head>

<body class="bg-white">
    <main class="loginColumns animated fadeInDown">
        <div class="row content-log justify-content-between">
            <div class="col-md-6 text-center">
                <div class="row justify-content-center">
                    <div class="col-3">
                        <img src="{{ asset('assets/img/logo_dinkes.png') }}" class="img-fluid" alt="dinkes_prov">
                    </div>
                </div>
                <h2 class="welcome">{{__('menu_wording.title')}}</h2>
                <h2>Dinas Kesehatan Provinsi Jawa Tengah</h2>
                <img src="{{ asset('assets/background/esertif_v2.png') }}" class="img-fluid" alt="cover">
            </div>
            <div class="col-md-5 m-auto" style="padding:0px 5%; ">
                <form action="{{route('manage.checklogin')}}"
                    role="form"
                    method="POST"
                    class="card px-4 pt-5 pb-4 shadow"
                    >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <label class="d-block">
                                <p>Username</p>
                                <select class="form-control" name="akun" id="select_user" required>
                                </select>
                            </label>
                            <label class="d-block mt-4">
                                <p>Password</p>
                                <input type="password" 
                                    name="password"
                                    class="form-control" 
                                    placeholder="Masukkan Username"
                                    autocomplete="current-password"
                                    required>
                            </label>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit"
                            class="btn btn-block btn-danger"
                            >Login
                        </button>
                    </div>
                </form>
                    {{-- <div class="txt-login">Login</div> --}}
                    {{-- <br/> --}}
                    @if(session('message'))
                    <div class="alert alert-{{session('message')['status']}}">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('message')['desc'] }}
                    </div>
                    @endif
                    {{-- <p>Cari Sertifikat Kader <a href="{{ route('search_sertifikat') }}" class="btn btn-primary"><i class="fa fa-search"></i> disini</a> </p> --}}
            </div>
        </div>
        {{-- <hr/>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6 text-right">
                <strong>Copyright <span style="color:#1ab394;">Rapier Teknologi Nasional © 2022</span></strong>
            </div>
        </div> --}}
    </main>
    <footer class="border-top pt-3 px-5">
        <p class="text-right">
            <strong>Copyright <span style="color:#1ab394;">Rapier Teknologi Nasional © 2022</span></strong>
        </p>
    </footer>

    <script src="{{ asset('assets/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Peity -->
    <script src="{{ asset('assets/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{ asset('assets/js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('assets/js/inspinia.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{ asset('assets/js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('assets/js/demo/sparkline-demo.js')}}"></script>

    <!-- Data picker -->
    <script src="{{ asset('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/js/plugins/toastr/toastr.min.js')}}"></script>


    <!-- iCheck -->
    <script src="{{ asset('assets/js/plugins/iCheck/icheck.min.js')}}"></script>


    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('assets/js/plugins/fullcalendar/moment.min.js')}}"></script>

    <!-- Date range picker -->
    <script src="{{ asset('assets/js/plugins/daterangepicker/daterangepicker.js')}}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js')}}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('assets/js/plugins/validate/jquery.validate.min.js')}}"></script>

    <!-- Sweet alert -->
    <script src="{{ asset('assets/js/plugins/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('assets/js/chart.min.js')}}"></script>
    <script>
        $("#select_user").select2({
            placeholder: "Pilih User .....",
            allowClear: true,
            ajax: {
                url: "{{ route('filter_user') }}",
                dataType: 'JSON',
                data: function(params) {
                    return {
                        search: params.term,
                        // kabupaten: $('#select_kab option:selected').val()
                    }
                },
                processResults: function (data) {
                    var results = [];
                    $.each(data, function(index, item){
                        results.push({
                            id: item.name,
                            text : item.name,
                        });
                    });
                    return{
                        results: results
                    };
                }
            }
        });
    </script>

</body>

</html>
