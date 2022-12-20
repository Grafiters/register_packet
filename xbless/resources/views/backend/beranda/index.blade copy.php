@extends('layouts.layout')

@section('title', 'Beranda')

@section('content')
    <style>
        .label-chart {
            display: inline-block;
            width: 2rem;
            height: 1rem;
            margin-right: .5rem;
        }
    </style>

    <div class="wrapper wrapper-content animated fadeInRight">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center m-t-lg">
                    @if (session('message'))
                        <div class="alert alert-{{ session('message')['status'] }}">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ session('message')['desc'] }}
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col">
                        <a href="{{ route('master.puskesmas.index') }}">
                            <article class="card p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="mb-1 text-body">Jumlah Puskesmas</p>
                                        <h1 class="my-0 text-info">5</h1>
                                    </div>
                                    <div class="col-auto text-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" viewBox="0 0 256 256">
                                            <rect width="256" height="256" fill="none"></rect>
                                            <rect x="32" y="72" width="192" height="144" rx="8"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></rect>
                                            <path d="M168,72V56a16,16,0,0,0-16-16H104A16,16,0,0,0,88,56V72" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16"></path>
                                            <line x1="128" y1="116" x2="128" y2="172" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16"></line>
                                            <line x1="156" y1="144" x2="100" y2="144" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16"></line>
                                        </svg>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('master.desa.index') }}">
                            <article class="card p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="mb-1 text-body">Jumlah Desa</p>
                                        <h1 class="my-0 text-success">5</h1>
                                    </div>
                                    <div class="col-auto text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" viewBox="0 0 256 256">
                                            <rect width="256" height="256" fill="none"></rect>
                                            <line x1="16" y1="216" x2="240" y2="216" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16"></line>
                                            <path d="M144,216V40a8,8,0,0,0-8-8H40a8,8,0,0,0-8,8V216" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16"></path>
                                            <path d="M224,216V104a8,8,0,0,0-8-8H144" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                                            <line x1="64" y1="72" x2="96" y2="72"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <line x1="80" y1="136" x2="112" y2="136"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <line x1="64" y1="176" x2="96" y2="176"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <line x1="176" y1="176" x2="192" y2="176"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <line x1="176" y1="136" x2="192" y2="136"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                        </svg>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('certificate.generate.index') }}">
                            <article class="card p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="mb-1 text-body">Jumlah Sertifikat Kader</p>
                                        <h1 class="my-0 text-danger">5</h1>
                                    </div>
                                    <div class="col-auto text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" viewBox="0 0 256 256">
                                            <rect width="256" height="256" fill="none"></rect>
                                            <line x1="96" y1="96" x2="160" y2="96"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <line x1="96" y1="128" x2="160" y2="128"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <line x1="96" y1="160" x2="128" y2="160"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></line>
                                            <path
                                                d="M156.7,216H48a8,8,0,0,1-8-8V48a8,8,0,0,1,8-8H208a8,8,0,0,1,8,8V156.7a7.9,7.9,0,0,1-2.3,5.6l-51.4,51.4A7.9,7.9,0,0,1,156.7,216Z"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="16"></path>
                                            <polyline points="215.3 160 160 160 160 215.3" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16"></polyline>
                                        </svg>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                </div>

                <hr class="my-5">

                <div class="row">
                    <div class="col-3">
                        <h3>Seluruh Kader</h3>
                        <div class="card p-3 mt-4">
                            <canvas id="chart-kader"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col">
                        <h3>Kader Per Kabupaten</h3>
                        <div class="card p-3 mt-4">
                            <canvas id="chart-kabupaten"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col">
                        <h3>Posyandu Per Kabupaten</h3>
                        <div class="card p-3 mt-4">
                            <div class="row justify-content-center mt-3">
                                <div class="col-auto">
                                    <div>
                                        <span class="label-chart"></span>
                                        <span>Purnama</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div>
                                        <span class="label-chart"></span>
                                        <span>Mandiri</span>
                                    </div>
                                </div>
                            </div>
                            <canvas id="chart-posyandu"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function(){
            const charKabupaten = document.getElementById("chart-kabupaten").getContext("2d");
            const charPosKabupaten = document.getElementById("chart-posyandu").getContext("2d");
            const chartPie = document.getElementById("chart-kader").getContext("2d");

            data_chart2(charKabupaten, charPosKabupaten, chartPie)
            // data_chart1(charPosKabupaten)
        })
        const labelChart = document.querySelectorAll(".label-chart")

        const bgColor =[
            "rgb(255, 99, 132)",
            "rgb(54, 162, 235)",
        ]
        labelChart[0].style.backgroundColor = bgColor[0]
        labelChart[1].style.backgroundColor = bgColor[1]

        const kaderLabel = ["Purnama", "Mandiri"]
        const configPie = {
            type: "pie",
            data: {
                labels: kaderLabel,
                datasets: [{
                        data: [],
                        backgroundColor: bgColor,
                        hoverOffset: 4,
                    },
                ],
            }
        }
        
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
                        color: 'white',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                backgroundColor: function(context) {
                    return context.dataset.backgroundColor;
                },
                indexAxis: 'x',
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
                        backgroundColor: function(context) {
                            return context.dataset.backgroundColor;
                        },
                        color: 'white',
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

        function data_chart2(charKabupaten, charPosKabupaten, chartPie){
            Chart.register(ChartDataLabels);
            var chart = new Chart(charKabupaten,config)
            var chart2 = new Chart(charPosKabupaten, config1)
            var pie     = new Chart(chartPie, configPie)
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                url: "{{route('beranda.getdata')}}",
                type: "POST",
                success: function(response){
                    console.log(response);
                    if(response.data.success){
                        chart.data.labels = response.data.kabupaten;
                        chart.data.datasets[0].data = response.data.nilai;

                        chart2.data.labels = response.data.kabupaten;
                        chart2.data.datasets[0].data = response.data.purnama.nilai;
                        chart2.data.datasets[1].data = response.data.mandiri.nilai;

                        pie.data.datasets[0].data = response.data.pie;

                        chart.update();
                        chart2.update();
                        pie.update();
                    }
                }
            })
        }

        const config1 = {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        axis: 'y',
                        label: 'Purnama',
                        data: [],
                        backgroundColor: [
                            bgColor[0]
                        ],
                        color: 'white',
                        borderWidth: 1
                    },
                    {
                        axis: 'y',
                        label: 'Mandiri',
                        data: [],
                        backgroundColor: [
                            bgColor[1]
                        ],
                        color: 'white',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                indexAxis: 'x',
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
                        color: 'white',
                        // borderRadius: 4,
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
                        stacked: false,
                    },
                    y: {
                        ticks : {
                            color : '#000000',
                        },
                        stacked: false,
                    }
                }
            }
        };

        // function data_chart1(charKabupaten){
        //     Chart.register(ChartDataLabels);
        //     var chart = new Chart(charKabupaten,config1)
        //     $.ajax({
        //         headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        //         url: "{{route('beranda.getdataposkab')}}",
        //         type: "POST",
        //         success: function(response){
        //             console.log(response);
        //             chart.data.labels = response.data.field;
        //             chart.data.datasets[0].data = response.data.purnama.nilai;
        //             chart.data.datasets[1].data = response.data.mandiri.nilai;
        //             chart.update();
        //         }
        //     })
        // }

    </script>
@endpush
