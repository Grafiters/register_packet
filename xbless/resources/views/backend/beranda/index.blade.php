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
                        <a href="#">
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
                        <a href="#">
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
                        <a href="#">
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
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="module">
        
    </script>
@endpush
