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
      @font-face {
        src: url("{{ asset('assets/fonts/Alex_Brush/AlexBrush-Regular.ttf') }}");
        font-family: 'AlexBrush' ;
      }
      .font-piagam {
        font-family: 'AlexBrush';
        color: #52489F;
        font-size: 64px;
      }
      @media print {
        @page {
          size: landscape;
        }
        body {
          -webkit-print-color-adjust: exact;
        }
      }

      body{background-color: initial}
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
      .table th, .table td {
        padding: 0.5rem;
        border: none
      }
    </style>
</head>
<body>
  <div
    style="font-family: 'Arial', monospace; width:297mm; height:210mm;" 
    id="section-to-print"
    >
    @foreach ($certificate as $data)
    <div 
      class="row no-gutters justify-content-center h-100"
      style="background: url('{{ asset('assets/img/back.png') }}') no-repeat; background-size: contain;"  
      >
      <div class="col-10">
        <div class="row h-100">
          <div class="col m-auto">
            <div class="row align-items-center justify-content-around">
              <div class="col-2">
                <img src="{{ asset('assets/img/logo_jateng_gayeng.png') }}" class="img-fluid" alt="jateng_gayeng">
              </div>
              <div class="col-2">
                <img src="{{ asset('assets/img/logo_dinkes.png') }}" class="img-fluid" alt="dinkes">
              </div>
              <div class="col-2">
                <img src="{{ asset('assets/img/logo_germas.png') }}" class="img-fluid" alt="germas">
              </div>
            </div>
            <p class="font-weight text-center" style="font-size: medium;">
              PEMERINTAH PROVINSI JAWA TENGAH <br>
              DINAS KESEHATAN
            </p>
            <h1 class="font-piagam text-center mt-4 mb-3">Piagam Penghargaan</h1>
            <div class="row">
              <div class="col text-center">
                <p class="mb-0">Nomor : <strong>{{ $data->nomor_certificate }}</strong></p>
                <p>Diberikan Kepada :</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="row justify-content-center">
                  <div class="col-6">
                    <div class="row py-2">
                      <div class="col-4">Nama</div>
                      <div class="col-auto px-0">:</div>
                      <div class="col font-bold">{{ $data->kader_name }}</div>
                    </div>
                    <div class="row py-2">
                      <div class="col-4">Posyandu</div>
                      <div class="col-auto px-0">:</div>
                      <div class="col font-bold">{{ $data->posyandu_name }}</div>
                    </div>
                    <div class="row py-2">
                      <div class="col-4">Desa / Kelurahan</div>
                      <div class="col-auto px-0">:</div>
                      <div class="col font-bold">{{ ucwords(strtolower($data->alamat)) }}</div>
                    </div>
                    <div class="row py-2">
                      <div class="col-4">Kabupaten / Kota</div>
                      <div class="col-auto px-0">:</div>
                      <div class="col font-bold">{{ $data->kabupaten_name }}</div>
                    </div>
                  </div>
                </div>
                <div class="row pt-4">
                  <div class="col">
                    <p class="text-uppercase text-center" style="font-size: 14px">
                      Atas partisipasinya sebagai kader posyandu dalam upaya meningkatkan derajat kesehatan<br/>
                      masyarakat untuk membudayakan perilaku hidup bersih dan sehat
                    </p>
                  </div>
                </div>
                <div class="row justify-content-between align-items-center">
                  <div class="col-4 text-center">{!! QrCode::size(75)->generate($link) !!}</div>
                  <div class="col-4 text-center">
                    <p class="mb-5 pb-4">Semarang, 03 Oktober 2022</p>
                    <p style="font-size: 12px; border-top: thin solid #555;" class="mb-0">Ditandangani secara elektronik oleh :</p>
                    <p style="font-size: 10px">
                      <b>Kepala Dinas Kesehatan</b><br/>
                      <b>Provinsi Jawa Tengah</b>
                    </p>
                    <p style="font-size: 10px">
                      <span class="font-bold">{{ $kadin->name }}</span><br/>
                      {{ $kadin->tingkatan }}<br/>
                      NIP. {{ $kadin->nip }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
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
