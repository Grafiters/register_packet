<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cutive+Mono&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
    @media print {
      body {
        -webkit-print-color-adjust: exact;
      }
    }

    #section-to-print{
      height: 700px;
    }
    table {border: none!important;}
    .table>thead>tr>th{
      border-bottom: none!important;
    }
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{
      border-top: none!important;
    }
    .center {
      margin-left: auto;
      margin-right: auto;
    }

    </style>
</head>
<body>
  <div class="card p-5" style="font-family: 'Arial', monospace;" id="section-to-print">
    @foreach ($certificate as $data)
    <div class="row" style="padding:10px;">
      <div class="col-sm-2">
        <img src="{{ asset('assets/img/left.png') }}" width="200px" height="100%" alt="border-left">
      </div>
      <div class="col-sm-8">
        <div class="text-center">
          <p class="font-weight" style="font-size: medium;"> PEMERINTAH PROVINSI JAWA TENGAH</p>
          <table class="table center" cellspacing="0" cellpadding="0" style="width:90%">
              <thead class="thead-white">
                  <tr class="text-center">
                      <th  colspan="3">NOMOR: {{ $data->nomor_certificate }}</th>
                  </tr>
                  <tr class="text-center">
                      <th  colspan="3">Di Berikan Kepada:</th>
                  </tr>
                  <tr class="text-left">
                      <th  width="30%">Nama</th>
                      <th  width="5%">:</th>
                      <th >{{ $data->getKader->fullname }}</th>
                  </tr>
                  <tr class="text-left">
                      <th  width="30%">Posyandu</th>
                      <th  width="5%">:</th>
                      <th >{{ $data->getPosyandu->name }}</th>
                  </tr>
                  <tr class="text-left">
                      <th  width="30%">Desa / Kelurahan</th>
                      <th  width="5%">:</th>
                      <th >{{ $data->getPuskesmas->kecamatan }}</th>
                  </tr>
                  <tr class="text-left">
                      <th  width="30%">Kabupaten / Kota</th>
                      <th  width="5%">:</th>
                      <th >{{ $data->getPuskesmas->kabupaten }}</th>
                  </tr>
                  <tr class="text-center">
                      <th  colspan="3">Atas partisipasinya sebagai kader posyandu dalam upaya meningkatkan derajat kesehatan<br/>
                        masyarakat untuk membudayakan perilaku hidup bersih dan sehat
                      </th>
                  </tr>
                  <tr class="text-center">
                      <th  colspan="3">
                        Semarang, Agustus 2022<br/>
                        Kepala Dinas Kesehatan<br/>
                        Provinsi Jawa Tengah
                      </th>
                  </tr>
                  <tr class="text-center" style="height: 100%">
                      <th colspan="2" rowspan="3" style="vertical-align: bottom">
                          <u>{!! QrCode::size(75)->generate('http://rapierteknologi.com/') !!}<br/>
                      </th>
                      <th  colspan="2">
                        ttd.
                      </th>
                  </tr>
                  <tr>
                      <th></th>
                  </tr>
                  <tr class="text-center">
                      <th colspan="2">
                        <u>Yunita Dyah Suminar.SKM.M.Sc.M.Si</u><br/>
                        Pembina Tingkat I <br/>
                        NIP. 198292719273492
                      </th>
                  </tr>
              </thead>
              <tbody>
          </table>
        </div>
      </div>
      <div class="col-sm-2">
        <img src="{{ asset('assets/img/right.png') }}" width="200px" height="100%" alt="border-right">
      </div>
    </div>
    @endforeach

  </div>
</body>
</html>

<script src="{{ asset('assets/js/jquery-3.1.1.min.js')}}"></script>
<script>
    $(document).ready(function(){
        window.print();
    })
</script>
