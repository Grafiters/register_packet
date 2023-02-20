@extends('layouts.landing.layout')
@section('title', 'Landing Page')
@section('content')
<style>
    #paket {
        display: flex;
        overflow-y: scroll;
        overflow-x: none;
        width: 100%;
        position: relative;
        flex-direction: row;
        white-space: nowrap;
    }

    #paket > li{
        display: inline-block;
        padding-left: 15px;
        padding-right: 15px;
        padding-bottom: 15px;
        font-family: 'Arial';
    }

    .list-paket > a{
        color: #a6a9b0;
    }

    .list-paket:hover,
    .list-paket > a:hover{
        color: black;
    }

    .list-paket.active > .paket_bottom_landing,
    .list-paket.active > a{
        color: black;
        border-bottom: 2px solid;
    }

    .box > h3{
        padding: 35px 0px 25px 0px !important;
        text-transform: capitalize !important;
    }

    .box > h3,
    .box > p,
    .box > .list_benefit > ul {
        text-align: left !important;
    }

    .box > .list_benefit > ul > li{
        padding-bottom: 10px !important;
    }

</style>
<main id="main" style="padding-top: 80px;">
    <div class="floating-container">
        <div class="floating button">+</div>
    </div>
<div class="container" data-aos="fade-up">
    <section style="padding: 15px 0px 15px 0px;">
        <div class="row aos-init aos-animate" data-aos-delay="150">
            <div class="col-lg-12 d-flex justify-content-center">
                <input type="hidden" id="id_paket" value="{{ $paket[0]->id }}">
                <ul id="paket">
                    @foreach ($paket as $item => $value)
                    <li class="list-group-item list-paket" id="paket_{{ $value->id }}" onclick="changeActive({{ $value->id }})">
                        <a href="#" ><h3 style="font-size: 1rem;"><b>{{ $value->name }}</b></h3></a>
                        <div class="paket_bottom_landing"></div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</div>
<div class="bg-white" style="background-color: #f8fbfe !important;">
    <section id="pricing" class="pricing" style="padding: 25px 0px 80px 0px;">
        <div class="container" data-aos="fade-up" id="response">
        </div>
    </section>
</div>
</main>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        checkActive()
    });

    function changeActive(id){
        const id_paket  = $('#id_paket').val()
        const prev_id   = `paket_${id_paket}`
        const next_id   = `paket_${id}`
        $(`#${prev_id}`).removeClass('active')
        $('#id_paket').val(id)
        checkActive()
    }

    function checkActive(){
        addDetailPaket()
        const id_paket = $('#id_paket').val()
        const id = `paket_${id_paket}`
        var liIds = $('#paket li').map(function(i, n){
            const paket = $(n).attr('id')
            if(paket == id){
                $(n).addClass('active')
            }
        }).get()
    }

    function addDetailPaket(){
        const id_paket = $('#id_paket').val()
        const response = fetchDetailPaket(id_paket)
    }

    function fetchDetailPaket(id_paket){
        Swal.showLoading();
        $.ajax({
            type: 'GET',
            url : "{{route('paket')}}",
            data:{
                paket: id_paket
            },
            dataType: "json",
            success: function(response){
                if(response.code == 201){
                    fetchDataDetailPaket(response.data)
                }
                Swal.close()
            },
        });
    }

    function register(code){
        console.log(code)
    }
        
    function fetchDataDetailPaket(data){
        console.log(data.detail)
        $('#response').empty()
        const parent = document.createElement('div');
        $(parent).addClass('section-title')
        const description = document.createElement('p')
        $(parent).append($(description).text(data.description))

        const row = document.createElement('div')
        $(row).addClass('row')
        var detail = data.detail.map(function(value, index){        
            const elemChild = document.createElement('div')
            $(elemChild).addClass('col-lg-3')
            $(elemChild).attr('data-aos', 'zoom-im')
            $(elemChild).attr('data-aos-delay', '100')

            const elemGrandChild = document.createElement('div')
            $(elemGrandChild).addClass('box')

            const speed = document.createElement('b')
            const icon = document.createElement('i')
            $(icon).addClass('fa fa-wifi')
            $(icon).addClass('text-danger')
            $(speed).text(' Speed')
            $(speed).prepend(icon)
            $(elemGrandChild).append(speed)

            const title = document.createElement('h3')
            $(title).text(`${value.speed} Mbps`)
            $(title).addClass('title_card')
            $(title).attr('style', 'font-size: 15px')
            $(elemGrandChild).append(title)

            const price = document.createElement('p')
            $(price).text(`${value.price}/Bulan`)
            $(price).attr('style', 'font-size: 14px')
            $(elemGrandChild).append(price)

            const separator = document.createElement('hr')
            $(elemGrandChild).append(separator)
            
            const titleBenefit = document.createElement('b')
            const iconBenefit = document.createElement('i')
            $(iconBenefit).addClass('fa fa-tags')
            $(iconBenefit).addClass('text-danger')
            $(titleBenefit).text(' Benefit')
            $(titleBenefit).attr('style', 'font-size: 14px')
            const space = document.createElement('h2')
            $(titleBenefit).append(space)
            $(titleBenefit).prepend(iconBenefit)
            $(elemGrandChild).append(titleBenefit)

            const benefit = document.createElement('div')
            $(benefit).addClass('list_benefit')
            $(benefit).append(value.description)
            $(elemGrandChild).append(benefit)

            const button = document.createElement('a')
            $(button).text('Pilih Paket')
            $(button).addClass('btn btn-danger')
            const route = `{{ route('confirm', [null]) }}/` + value.code
            $(button).attr('href', route)
            $(elemGrandChild).append(button)

            const justify_content = document.createElement('div')
            $(justify_content).addClass('col-md')
            $(elemChild).prepend(justify_content)

            $(elemChild).append(elemGrandChild)
            row.append(elemChild)
        })
        
        $('#response').append(parent)
        $('#response').append(row)
    }
</script>
@endpush
