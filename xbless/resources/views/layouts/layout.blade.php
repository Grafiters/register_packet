<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('menu_wording.title')}} - @yield('title') </title>

    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/all.min.css')}}" rel="stylesheet">

    {{-- favicon --}}
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="" type="image/x-icon">

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
    <link href="{{ asset('assets/css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">

    <link href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet">
    @stack('stylesheets')
    <style>
        *,
        body,
        html {
            font-size: 12px;
        }

        .dataTables_wrapper.container-fluid {
            width: 100%;
            padding-right: 0;
            padding-left: 0;
        }

        .rotate-text {
            writing-mode: tb-rl;
            transform: rotate(-180deg);
            vertical-align: middle;
        }

        input.form-control {
            padding: 1rem;
            font-size: 12px;
        }

        .col-form-label {
            padding-left: 0;
        }

        .modal-body input {
            border: 1px solid rgb(27, 27, 27, 0.4);
        }
    </style>
</head>

<body class="skin-1">

    <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg" style="padding-bottom: 5rem">

            <!-- Page wrapper -->
            @include('layouts.topnavbar')

            <!-- Main view  -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->


    <!-- Mainly scripts -->
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugins/dataTables/datatables.min.js')}}"></script>
    {{-- <script src="{{ asset('assets/js/dataTables.keyTable.min.js')}}"></script> --}}
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

    <!-- SUMMERNOTE -->
    <script src="{{ asset('assets/js/plugins/summernote/summernote-bs4.js') }}"></script>

    <script type="text/javascript"
        src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>

    <script src="{{ asset('assets/js/plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js')}}"></script>
    <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    @stack('scripts')
    <script>
        $.fn.dataTable.ext.errMode = 'none';
    </script>
</body>
<script>
    // var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $SIDEBAR_MENU = $('#side-menu');

    // Sidebar
    $(document).ready(function() {
        // TODO: This is some kind of easy fix, maybe we can improve this
        // check active menu
        var segments = CURRENT_URL.split( '/' );
        // console.log(segments[]);
        var iniurl = window.location.origin;
        var tamp = ''+iniurl;

        for(var i=0; i<segments.length; i++){
            if(i>=3){
                tamp += '/'+segments[i];
            }


        }
        // console.log(tamp);
        // var potongurl= iniurl+'/'+segments[3]+'/'+segments[4]+'/'+segments[5]+'/'+segments[6];
        var potongurl= tamp;
        // console.log($SIDEBAR_MENU);
        $SIDEBAR_MENU.find('ul a[href="' + potongurl + '"]').parents('li').addClass('active');
        $SIDEBAR_MENU.find('ul a[href="' + potongurl + '"]').parents('ul').addClass('in');
        // console.log($SIDEBAR_MENU);
        $SIDEBAR_MENU.find('a').filter(function () {
            return this.href == potongurl;
        }).addClass('active').parents('li').slideDown(function() {
        });
    });
</script>
<script>
    var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $SIDEBAR_MENU = $('#side-menu');

    // Sidebar
    $(document).ready(function() {
        // TODO: This is some kind of easy fix, maybe we can improve this
        // check active menu
        var segments = CURRENT_URL.split( '/' );
        // console.log(segments[]);
        var iniurl = window.location.origin;
        var tamp = ''+iniurl;

        for(var i=0; i<segments.length; i++){
            if(i>=3){
                tamp += '/'+segments[i];
            }


        }
        // console.log(tamp);
        // var potongurl= iniurl+'/'+segments[3]+'/'+segments[4]+'/'+segments[5]+'/'+segments[6];
        var potongurl= tamp;
        // console.log($SIDEBAR_MENU);
        $SIDEBAR_MENU.find('ul a[href="' + potongurl + '"]').parents('li').addClass('active');
        $SIDEBAR_MENU.find('ul a[href="' + potongurl + '"]').parents('ul').addClass('in');
        // console.log($SIDEBAR_MENU);
        $SIDEBAR_MENU.find('a').filter(function () {
            return this.href == potongurl;
        }).addClass('active').parents('li').slideDown(function() {
        });
    });
</script>

</html>
