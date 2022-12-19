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
                                <input type="text" 
                                    name="akun"
                                    class="form-control" 
                                    placeholder="Masukkan Username"
                                    autocomplete="username"
                                    required>
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
                    {{-- <form class="m-t" role="form" action="{{route('manage.checklogin')}}" method="post">
                        {{ csrf_field() }}
                        <div class="ibox-content">
                            <div class="ml-input txtinput">Username</div>
                            <div class="form-group ml-input">
                                <input type="text" class="form-control form__field" name="akun" placeholder="Masukan Username" required="">
                            </div>
                            <div class="line_login"></div>
                            <div class="ml-input txtinput">Password</div>
                            <div class="form-group ml-input">
                                <input type="password" class="form-control form__field" name="password" placeholder="Masukkan Password" required="">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success block full-width m-b btnlogin">Login</button>
                    </form> --}}
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

    {{-- Mainly scripts --}}
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js')}}"></script>
    {{-- Jquery Validate --}}
    <script src="{{ asset('assets/js/plugins/validate/jquery.validate.min.js')}}"></script>

</body>

</html>
