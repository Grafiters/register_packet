@extends('layouts.layout')

@section('title', 'Beranda')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content b-r-lg" style="background-color: #1AB394;">
                    <div class="d-flex justify-content-start">
                        <div class="form-group row col-md my-auto">
                            <label class="col-sm-2 col-form-label font-bold" style="color: white;">Kabupaten</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="select_kab" name="kabupaten" {{ (auth()->user()->can('kabupaten.index') || auth()->user()->can('puskesmas.index'))? 'disabled' : '' }}>
                                    <option value="">Pilih Kabupaten .....</option>
                                    @foreach($kabupaten as $key => $value)
                                    <option value="{{$value->id}}" {{ ($selectedkab == $value->id)? 'selected' : '' }} >{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row col-md my-auto">
                            <label class="col-sm-2 col-form-label font-bold" style="color: white;">Puskesmas</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="select_pusk" name="puskesmas" {{ (auth()->user()->can('puskesmas.index'))? 'disabled' : '' }}>
                                    @if(auth()->user()->can('puskesmas.index'))
                                    <option value="{{ $puskesmas->id }}">{{ $puskesmas->name }}</option>
                                    @else
                                    <option value="">Pilih Puskesmas .....</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group row col-md my-auto">
                            <label class="col-sm-3 col-form-label font-bold" style="color: white;">Range Periode</label>
                            <div class="col-sm-9 my-auto">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control rounded-left periode"
                                        id="start" name="start" value="{{ date('M-Y') }}" />
                                    <span class="input-group-addon px-3 bg-primary">to</span>
                                    <input type="text" class="form-control-sm form-control rounded-right periode"
                                        id="end" name="end" value="{{ date('M-Y') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-content position-relative b-r-lg px-5">
                    <div class="row pl-2">
                        <p class="fw-600">Jumlah Deteksi Dini Faktor Risiko</p>
                    </div>
                    <div class="row d-flex justify-content-between px-2">
                        <div class="fw-600">
                            <div class="text-center" style="line-height:10px;">
                                <p class="fs-20" id="dd_merokok">0</p>
                                <p class="mt-2 fs-12">Merokok</p>
                            </div>
                        </div>
                        <div class="fw-600">
                            <div class="text-center" style="line-height:10px;">
                                <p class="fs-20" id="dd_kurangaktifitas">0</p>
                                <p class="mt-2 fs-12" style="line-height:16px;">Kurang <br>
                                    Aktifitas fisik</p>
                            </div>
                        </div>
                        <div class="fw-600">
                            <div class="text-center" style="line-height:10px;">
                                <p class="fs-20" id="dd_diet">0</p>
                                <p class="mt-2 fs-12" style="line-height:16px;">Diet Tidak <br>
                                    Seimbang</p>
                            </div>
                        </div>
                        <div class="fw-600">
                            <div class="text-center" style="line-height:10px;">
                                <p class="fs-20" id="dd_alkohol">0</p>
                                <p class="mt-2 fs-12" style="line-height:16px;">Konsumsi <br>
                                    Alkohol</p>
                            </div>
                        </div>
                        {{-- <div class="fw-600">
                            <div class="text-center" style="line-height:10px;">
                                <p class="fs-20" id="dd_odmk">0</p>
                                <p class="mt-2 fs-12">ODMK</p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row pl-2 pb-1 d-flex justify-content-start align-items-center">
                        <button class="btn btn-success  btn-large" type="button">
                            <i class="fa fa-stethoscope p-2"></i>
                        </button>
                        <div class="ml-3 mt-2 fw-600" style="line-height: 5px;">
                            <p>Total Deteksi Dini</p>
                            {{-- Sumber data : Total Jumlah Hadir --}}
                            <p class="mt-3 fs-20" id="dd_total">0</p>
                        </div>
                    </div>
                    <div class="row position-absolute" style="bottom:0; right:0;">
                        <div class="col-12">
                            <a class="px-4 py-2 bg-green text-white" href="{{route('keswa.index')}}">
                                Selengkapnya
                                <i class="fas fa-chevron-right ml-3" style="font-size: 12px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content b-r-lg" style="border: 0;">
                    <h4 class="">Grafik 10 Kasus Penyakit Tidak Menular teratas</h4>
                    <canvas id="bar-chart"></canvas>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content b-r-lg" style="border: 0;">
                    <h4 class="">Grafik 10 Kasus Gangguan Jiwa teratas</h5>
                        <canvas id="bar-chart-jiwa"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content b-r-lg" style="border: 0;">
                    <h4 class="">Presentase Indikator SPM Pelayanan Kesehatan Usia Produktif</h4>
                    <canvas id="bar-chart-spm-uspro"></canvas>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content b-r-lg" style="border: 0;">
                    <h4 class="">Presentase Indikator SPM Pelayanan Kesehatan Penderita Hipertensi</h5>
                        <canvas id="bar-chart-spm-hipertensi"></canvas>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content b-r-lg" style="border: 0;">
                    <h4 class="">Presentase Indikator SPM Pelayanan Kesehatan Penderita Diabetes Melitus</h5>
                        <canvas id="bar-chart-spm-dm"></canvas>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content b-r-lg" style="border: 0;">
                    <h4 class="">Presentase Indikator SPM Pelayanan Kesehatan ODGJ</h5>
                        <canvas id="bar-chart-spm-odgj"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title bg-green">
                    <h5 class="text-white w-100" style="line-height: 20px; font-size:11px;">Top 5 Teratas Jumlah
                        ODGJ
                        Berat Mendapatkan
                        Pelayanan Sesuai Standar
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="donat-chart2-data" style="display: none" class="text-center">Belum ada data</h3>
                            <canvas id="donat-chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title bg-green">
                    <h5 class="text-white w-100" style="line-height: 20px; font-size:11px;">Top 5 Jumlah Sekrining
                        ASSIST di Puskesmas
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="donat-chart-data" style="display: none" class="text-center">Belum ada data</h3>
                            <canvas id="donat-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

@endsection
@push('scripts')


<script type="text/javascript">
    $(document).ready(function(){
        $("#select_kab").select2();
        $("#select_pusk").select2({
            placeholder: "Pilih Puskesmas .....",
            allowClear: true,
            ajax: {
                url: "{{ route('jiwa.filter_puskesmas') }}",
                dataType: 'JSON',
                data: function(params) {
                    return {
                        search: params.term,
                        kabupaten: $('#select_kab option:selected').val()
                    }
                },
                processResults: function (data) {
                    var results = [];
                    $.each(data, function(index, item){
                        results.push({
                            id: item.id,
                            text : item.name,
                        });
                    });
                    return{
                        results: results
                    };
                }
            }
        });
        $('.periode').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true,
                format: "M-yyyy"
        });
            var periode = $('#periode').val()
            // data_assist(periode);
            data_deteksidini(periode);
            // console.log('tes');
    });

    //start grafik kasus ptm
    const config = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    axis: 'y',
                    label: '',
                    data: [],
                    backgroundColor: [
                    '#EB5757',
                    '#F2994A',
                    '#F2C94C',
                    '#219653',
                    '#27AE60',
                    '#6FCF97',
                    '#2F80ED',
                    '#56CCF2',
                    '#9B51E0',
                    '#6A6965',
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive : true,
            maintainAspectRatio : true,
            aspectRatio : 3,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    align: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    anchor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    borderRadius: 4,
                    color: 'white',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    formatter: Math.round,
                    padding: 2,
                }
            },
            layout: {
                padding: {
                    top: 32,
                    right: 16,
                    bottom: 16,
                    left: 8
                }
            },
            scales: {
                x: {
                    grid : {
                        display : false,
                    },
                    stacked: true,
                },
                y: {
                    ticks : {
                        color : '#000',
                    },
                    stacked: true,
                }
            }
        }
    };
    $(document).ready(function(){

        var ctx = document.getElementById('bar-chart').getContext('2d')
        var ctx_jiwa = document.getElementById('bar-chart-jiwa').getContext('2d')
        var ctx_spm_uspro = document.getElementById('bar-chart-spm-uspro').getContext('2d')
        var ctx_spm_hipertensi = document.getElementById('bar-chart-spm-hipertensi').getContext('2d')
        var ctx_spm_dm = document.getElementById('bar-chart-spm-dm').getContext('2d')
        var ctx_spm_odgj = document.getElementById('bar-chart-spm-odgj').getContext('2d')
        var periode_start = $('#start').val()
        var periode_end = $('#end').val()
        // var periode_jiwa = $('#periode').val()
        // var periode_spm_uspro = $('#periode').val()
        // var periode_spm_hipertensi = $('#periode').val()
        // var periode_spm_dm = $('#periode').val()
        // var periode_spm_odgj = $('#periode').val()
        data_chart(ctx, periode_start, periode_end)
        data_chart_jiwa(ctx_jiwa, periode_start, periode_end)
        data_chart_spm_uspro(ctx_spm_uspro, periode_start, periode_end)
        data_chart_spm_hipertensi(ctx_spm_hipertensi, periode_start, periode_end)
        data_chart_spm_dm(ctx_spm_dm, periode_start, periode_end)
        data_chart_spm_odgj(ctx_spm_odgj, periode_start, periode_end)
    })

    $(document).on('change','.periode, #select_kab, #select_pusk', function(){
        var chart_status = Chart.getChart('bar-chart')
        var chart_status2 = Chart.getChart('bar-chart-jiwa')
        var chart_status11 = Chart.getChart('bar-chart-spm-uspro')
        var chart_status12 = Chart.getChart('bar-chart-spm-hipertensi')
        var chart_status13 = Chart.getChart('bar-chart-spm-dm')
        var chart_status14 = Chart.getChart('bar-chart-spm-odgj')
        if (chart_status != undefined) {
            chart_status.destroy();
        }if (chart_status2 != undefined) {
            chart_status2.destroy();
        }if (chart_status11 != undefined) {
            chart_status11.destroy();
        }if (chart_status12 != undefined) {
            chart_status12.destroy();
        }if (chart_status13 != undefined) {
            chart_status13.destroy();
        }if (chart_status14 != undefined) {
            chart_status14.destroy();
        }
        var ctx = document.getElementById('bar-chart').getContext('2d')
        var ctx_jiwa = document.getElementById('bar-chart-jiwa').getContext('2d')
        var ctx_spm_uspro = document.getElementById('bar-chart-spm-uspro').getContext('2d')
        var ctx_spm_hipertensi = document.getElementById('bar-chart-spm-hipertensi').getContext('2d')
        var ctx_spm_dm = document.getElementById('bar-chart-spm-dm').getContext('2d')
        var ctx_spm_odgj = document.getElementById('bar-chart-spm-odgj').getContext('2d')
        var periode_start = $('#start').val()
        var periode_end = $('#end').val()
        // var periode_jiwa = $('#periode').val()
        // var periode_spm_uspro = $('#periode').val()
        // var periode_spm_hipertensi = $('#periode').val()
        // var periode_spm_dm = $('#periode').val()
        // var periode_spm_odgj = $('#periode').val()
        data_chart(ctx, periode_start, periode_end)
        data_chart_jiwa(ctx_jiwa, periode_start, periode_end)
        data_chart_spm_uspro(ctx_spm_uspro, periode_start, periode_end)
        data_chart_spm_hipertensi(ctx_spm_hipertensi, periode_start, periode_end)
        data_chart_spm_dm(ctx_spm_dm, periode_start, periode_end)
        data_chart_spm_odgj(ctx_spm_odgj, periode_start, periode_end)
        data_deteksidini(periode_start, periode_end);
    })

    function data_chart(ctx, periode_start, periode_end){
        var kabupaten = $('#select_kab').val();
        Chart.register(ChartDataLabels);
        var chart = new Chart(ctx,config)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('analisa_kasus_ptm.data_chart')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                chart.data.labels = response.data.field ;
                chart.data.datasets[0].data = response.data.data;
                chart.update();
            }
        })
    }
    //end grafik kasus ptm

    //start grafik jiwa
    const config_jiwa = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    axis: 'y',
                    label: '',
                    data: [],
                    backgroundColor: [
                    '#EB5757',
                    '#F2994A',
                    '#F2C94C',
                    '#219653',
                    '#27AE60',
                    '#6FCF97',
                    '#2F80ED',
                    '#56CCF2',
                    '#9B51E0',
                    '#6A6965',
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive : true,
            maintainAspectRatio : true,
            aspectRatio : 3,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    align: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    anchor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    borderRadius: 4,
                    color: 'white',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    formatter: Math.round,
                    padding: 2,
                }
            },
            layout: {
                padding: {
                    top: 32,
                    right: 16,
                    bottom: 16,
                    left: 8
                }
            },
            scales: {
                x: {
                    grid : {
                        display : false,
                    },
                    stacked: true,
                },
                y: {
                    ticks : {
                        color : '#000',
                    },
                    stacked: true,
                }
            }
        }
    };

    function data_chart_jiwa(ctx_jiwa, periode_start, periode_end){
        Chart.register(ChartDataLabels);
        var chart = new Chart(ctx_jiwa,config_jiwa)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('analisa_kasus_jiwa.data_chart_beranda')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                chart.data.labels = response.data.field ;
                chart.data.datasets[0].data = response.data.data;
                chart.update();
            }
        })
    }
    // end grafik kasis jiwa

    // Start Grafik Indikator
    //uspro
    const config_spm_uspro = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    axis: 'y',
                    label: '',
                    data: [],
                    backgroundColor: [
                    '#EB5757',
                    '#F2994A',
                    '#F2C94C',
                    '#219653',
                    '#27AE60',
                    '#6FCF97',
                    '#2F80ED',
                    '#56CCF2',
                    '#9B51E0',
                    '#6A6965',
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive : true,
            maintainAspectRatio : true,
            aspectRatio : 3,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    align: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    anchor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    borderRadius: 4,
                    color: 'white',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    formatter: Math.round,
                    padding: 2,
                }
            },
            layout: {
                padding: {
                    top: 32,
                    right: 16,
                    bottom: 16,
                    left: 8
                }
            },
            scales: {
                x: {
                    grid : {
                        display : false,
                    },
                    stacked: true,
                },
                y: {
                    ticks : {
                        color : '#000',
                    },
                    stacked: true,
                }
            }
        }
    };

    function data_chart_spm_uspro(ctx_spm_uspro, periode_start, periode_end){
        Chart.register(ChartDataLabels);
        var chart = new Chart(ctx_spm_uspro,config_spm_uspro)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('spm.data_chart_uspro')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                chart.data.labels = response.data.field ;
                chart.data.datasets[0].data = response.data.data;
                chart.update();
            }
        })
    }

    //hipertensi
    const config_spm_hipertensi = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    axis: 'y',
                    label: '',
                    data: [],
                    backgroundColor: [
                    '#EB5757',
                    '#F2994A',
                    '#F2C94C',
                    '#219653',
                    '#27AE60',
                    '#6FCF97',
                    '#2F80ED',
                    '#56CCF2',
                    '#9B51E0',
                    '#6A6965',
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive : true,
            maintainAspectRatio : true,
            aspectRatio : 3,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    align: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    anchor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    borderRadius: 4,
                    color: 'white',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    formatter: Math.round,
                    padding: 2,
                }
            },
            layout: {
                padding: {
                    top: 32,
                    right: 16,
                    bottom: 16,
                    left: 8
                }
            },
            scales: {
                x: {
                    grid : {
                        display : false,
                    },
                    stacked: true,
                },
                y: {
                    ticks : {
                        color : '#000',
                    },
                    stacked: true,
                }
            }
        }
    };

    function data_chart_spm_hipertensi(ctx_spm_hipertensi, periode_start, periode_end){
        Chart.register(ChartDataLabels);
        var chart = new Chart(ctx_spm_hipertensi,config_spm_hipertensi)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('spm.data_chart_hipertensi')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                chart.data.labels = response.data.field ;
                chart.data.datasets[0].data = response.data.data;
                chart.update();
            }
        })
    }

    //dm
    const config_spm_dm = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    axis: 'y',
                    label: '',
                    data: [],
                    backgroundColor: [
                    '#EB5757',
                    '#F2994A',
                    '#F2C94C',
                    '#219653',
                    '#27AE60',
                    '#6FCF97',
                    '#2F80ED',
                    '#56CCF2',
                    '#9B51E0',
                    '#6A6965',
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive : true,
            maintainAspectRatio : true,
            aspectRatio : 3,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    align: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    anchor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    borderRadius: 4,
                    color: 'white',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    formatter: Math.round,
                    padding: 2,
                }
            },
            layout: {
                padding: {
                    top: 32,
                    right: 16,
                    bottom: 16,
                    left: 8
                }
            },
            scales: {
                x: {
                    grid : {
                        display : false,
                    },
                    stacked: true,
                },
                y: {
                    ticks : {
                        color : '#000',
                    },
                    stacked: true,
                }
            }
        }
    };

    function data_chart_spm_dm(ctx_spm_dm, periode_start, periode_end){
        Chart.register(ChartDataLabels);
        var chart = new Chart(ctx_spm_dm,config_spm_dm)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('spm.data_chart_dm')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                chart.data.labels = response.data.field ;
                chart.data.datasets[0].data = response.data.data;
                chart.update();
            }
        })
    }

    //odgj
    const config_spm_odgj = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    axis: 'y',
                    label: '',
                    data: [],
                    backgroundColor: [
                    '#EB5757',
                    '#F2994A',
                    '#F2C94C',
                    '#219653',
                    '#27AE60',
                    '#6FCF97',
                    '#2F80ED',
                    '#56CCF2',
                    '#9B51E0',
                    '#6A6965',
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive : true,
            maintainAspectRatio : true,
            aspectRatio : 3,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: ''
                },
                datalabels: {
                    align: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    anchor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        if (value == 0){
                            return value > 0 ? 'start' : 'end';
                        }else{
                            return value > 0 ? 'end' : 'start';
                        }
                    },
                    borderRadius: 4,
                    color: 'white',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    formatter: Math.round,
                    padding: 2,
                }
            },
            layout: {
                padding: {
                    top: 32,
                    right: 16,
                    bottom: 16,
                    left: 8
                }
            },
            scales: {
                x: {
                    grid : {
                        display : false,
                    },
                    stacked: true,
                },
                y: {
                    ticks : {
                        color : '#000',
                    },
                    stacked: true,
                }
            }
        }
    };

    function data_chart_spm_odgj(ctx_spm_odgj, periode_start, periode_end){
        Chart.register(ChartDataLabels);
        var chart = new Chart(ctx_spm_odgj,config_spm_odgj)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('spm.data_chart_odgj')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                chart.data.labels = response.data.field ;
                chart.data.datasets[0].data = response.data.data;
                chart.update();
            }
        })
    }


    // end Grafik Indikator


    function data_deteksidini(periode_start, periode_end){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{route('beranda.getDataDeteksidini')}}",
            type: "POST",
            data: {
                periode_start: periode_start,
                periode_end: periode_end,
                kabupaten: $('#select_kab').val(),
                puskesmas: $('#select_pusk').val()
            },
            success: function(response){
                console.log(response);
                $('#dd_merokok').text(response.merokok);
                $('#dd_kurangaktifitas').text(response.kurang_aktifitas);
                $('#dd_diet').text(response.diet);
                $('#dd_alkohol').text(response.alkohol);
                $('#dd_total').text(response.jml_hadir);
                // var total = response.merokok + response.kurang_aktifitas + response.diet + response.alkohol
                // $('#dd_total').text(total);

            }
        })
    }

</script>
@endpush
