@extends('layouts.layout')

@section('title', 'Generate Certificate / Detail')

@section('content')
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
        .swal2-container {
            z-index: 100000 !important;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        #section-to-print {
            height: 500px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
            background-image: url({{ url('assets/img/back.png') }});
        }

        table {
            border: none !important;
        }

        .table>thead>tr>th {
            border-bottom: none !important;
        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            border-top: none !important;
        }
    </style>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Detail Sertifikat</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('manage.beranda') }}">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Sertifikat </a>
                </li>
                <li class="breadcrumb-item active">
                    <a>Detail Sertifikat </a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <br />
            {{-- <button id="refresh" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
            title="Refresh Data"><span class="fa fa-refresh"></span></button> --}}
            @can('certificate.generate.cetak')
                <a href="{{ route('certificate.generate.cetak', $enc_id) }}" target="__blank" class="btn btn-success"
                    data-toggle="tooltip" data-placement="top" title="Print"><span class="fa fa-print"></span>&nbsp; Print</a>
                {{-- <button onclick="cetak()" class="btn btn-success"> Print</button> --}}
            @endcan
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}

        <div class="m-auto" style="font-family: 'Arial', monospace; width:297mm; height:210mm;" id="section-to-print">
            <div class="row no-gutters justify-content-center h-100"
                style="background: url('{{ asset('assets/img/back.png') }}') no-repeat; background-size: contain;">
                <div class="col-10">
                    <div class="row h-100">
                        <div class="col m-auto">
                            <div class="row align-items-center justify-content-around">
                                <div class="col-2">
                                    <img src="{{ asset('assets/img/logo_jateng_gayeng.png') }}" class="img-fluid"
                                        alt="jateng_gayeng">
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
                                    <p class="mb-0">Nomor : <strong>{{ $certificate->nomor_certificate }}</strong></p>
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
                                                <div class="col font-bold">{{ $certificate->kader_name }}</div>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col-4">Posyandu</div>
                                                <div class="col-auto px-0">:</div>
                                                <div class="col font-bold">{{ $certificate->posyandu_name }}</div>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col-4">Desa / Kelurahan</div>
                                                <div class="col-auto px-0">:</div>
                                                <div class="col font-bold">{{ ucwords(strtolower($certificate->alamat)) }}
                                                </div>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col-4">Kabupaten / Kota</div>
                                                <div class="col-auto px-0">:</div>
                                                <div class="col font-bold">{{ $certificate->kabupaten_name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col">
                                            <p class="text-uppercase text-center" style="font-size: 14px">
                                                Atas partisipasinya sebagai kader posyandu dalam upaya meningkatkan derajat
                                                kesehatan<br />
                                                masyarakat untuk membudayakan perilaku hidup bersih dan sehat
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-4 text-center">{!! QrCode::size(75)->generate($link) !!}</div>
                                        <div class="col-4 text-center">
                                            <p class="mb-5 pb-4">Semarang, 03 Oktober 2022</p>
                                            <p style="font-size: 12px; border-top: thin solid #555;" class="mb-0">
                                                Ditandangani secara elektronik oleh :</p>
                                            <p style="font-size: 10px">
                                                <b>Kepala Dinas Kesehatan</b><br />
                                                <b>Provinsi Jawa Tengah</b>
                                            </p>
                                            <p style="font-size: 10px">
                                                <span class="font-bold">{{ $kadin->name }}</span><br />
                                                {{ $kadin->tingkatan }}<br />
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
        </div>


    </div>
@endsection
@push('scripts')
    <script>
        function cetak() {
            window.print();
        }
    </script>
@endpush
