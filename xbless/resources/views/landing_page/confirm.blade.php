@extends('layouts.landing.layout')
@section('title', 'Confirmation')
@section('content')
<style>
    h4 {
        font-family: 'Arial';
    }
</style>
<main id="main" style="padding-top: 80px;">
<div class="container" data-aos="fade-up">
    <section style="padding: 15px 0px 15px 0px;">
        <div class="row aos-init aos-animate" data-aos-delay="150">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="section-title">
                    <h3 style="font-size: 25px !important;"><b>Form Registrasi</b></h3>
                    <h4>{{ $paket->paket }} - {{ $paket->speed }} / Mbps</h4>
                </div>
            </div>
        </div>
    </section>
</div>
<section id="contact" class="contact" style="background-color: #f8fbfe !important; justify-content: center !important;">
    <div class="container" data-aos="fade-up" style="background-color: white !important; box-shadow: 0px 2px 15px rgba(18, 66, 101, 0.08); border-radius: 15px;">
        <div class="p-4">
            <form id="submitData" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="code_paket" value="{{ $code }}">
                <div class="py-3">
                    <div class="title pb-4">
                        <div class="title text-center">
                            <h3><b>Detail User</b></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="fom-group col-md px-4">
                            <div class="input-group error-text">
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Nik" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            </div>
                        </div>
                        <div class="form-group col-md px-4">
                            <div class="input-group error-text">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md px-4">
                            <div class="input-group error-text">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group col-md px-4">
                            <div class="input-group error-text">
                                <input type="text" class="form-control" id="usaha" name="usaha" placeholder="Nama Usaha" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md px-4">
                            <div class="input-group error-text">
                                <input type="text" class="form-control" id="contact1" name="contact[]" placeholder="Nomor Hp 1" maxlength="12" minlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            </div>
                        </div>
                        <div class="form-group col-md px-4">
                            <div class="input-group error-text">
                                <input type="text" class="form-control" id="contact2" name="contact[]" placeholder="Nomor Hp 2" maxlength="12" minlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group px-4">
                            <div class="input-group error-text">
                                <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group px-4">
                            <div class="input-group error-text">
                                <textarea name="note" id="note" class="form-control" rows="3" placeholder="Note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="py-3">
                    <div class="title pb-3">
                        <div class="title text-center">
                            <h3><b>Gambar</b></h3>
                        </div>
                    </div>
                    <div class="input-group py-2">
                        <div class="custom-file">
                            <input id="ktp" type="file" class="custom-file-input" name="img_ktp" accept="image/*" alt="Foto KTP / SIM" onchange="checkImage('ktp')">
                            <label class="custom-file-label" for="ktp/sim" id="ktp_review">Foto KTP/SIM *</label>
                        </div>
                    </div>
                    <div class="input-group py-2">
                        <div class="custom-file">
                            <input id="kk" type="file" class="custom-file-input" name="img_kk" accept="image/*" alt="Foto KK" onchange="checkImage('kk')">
                            <label class="custom-file-label" for="ktp/sim" id="kk_review">Foto KK *</label>
                        </div>
                    </div>
                    <div class="input-group py-2">
                        <div class="custom-file">
                            <input id="selfie" type="file" class="custom-file-input" name="img_selfie" accept="image/*" alt="Foto Selfie Pegang KTP / SIM" onchange="checkImage('selfie')">
                            <label class="custom-file-label" for="ktp/sim" id="selfie_review">Foto Selfie pegang ktp / SIM *</label>
                        </div>
                    </div>
                    <div class="input-group py-2">
                        <div class="custom-file">
                            <input id="lokasi" type="file" class="custom-file-input" name="img_lokasi" accept="image/*" alt="Foto Lokasi Tampak Depan" onchange="checkImage('lokasi')">
                            <label class="custom-file-label" for="ktp/sim" id="lokasi_review">Foto Lokasi Tampak Depan *</label>
                        </div>
                    </div>
                    <div class="input-group py-2">
                        <div class="custom-file">
                            <input id="foto_usaha" type="file" class="custom-file-input" name="img_usaha" accept="image/*" onchange="checkImage('foto_usaha')">
                            <label class="custom-file-label" for="foto_usaha" id="foto_usaha_review">Foto Usaha (Jika Ada)</label>
                        </div>
                    </div>
                    <div class="input-group py-2">
                        <div class="custom-file">
                            <input id="nib" type="file" class="custom-file-input" name="img_nib" accept="image/*" onchange="checkImage('nib')">
                            <label class="custom-file-label" for="nib" id="nib_review">Foto NIB/SIUB/SKU (Jika Ada)</label>
                        </div>
                    </div>
                </div>
            </form>

            <div class="button text-center">
                <a href="{{route('index')}}" class="btn btn-small btn-danger" >Cancel</a>
                <button class="btn btn-success btn-small" type="submit" id="simpan">Simpan</button>
            </div>
        </div>
    </div>
</section><!-- End Contact Section -->
</main>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#simpan').on('click', function(event){
        const form = $('#submitData').serializeArray()
        const dataFile = new FormData()
        const img   = $('input[type="file"]')
        console.log(img)
        $.each(form, function(index, value){
            dataFile.append(value.name, value.value)
        })

        $.each(img, function(idx, value){
            file = value.files[0]
            dataFile.append(value.name, file)
        })

        $.ajax({
            type: 'POST',
            url: "{{ route('regis_paket') }}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data: dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                Swal.showLoading();
            },
            success: function(response) {
                Swal.hideLoading();
                if (response.code == 201) {
                        Swal.fire('Selamat',response.message,'info');
                    } else {
                        Swal.fire('Maaf',response.message,'info');
                    }
            },
            complete: function () {
                Swal.hideLoading();
                $('#simpan').removeClass("disabled");
            },
            error: function(response){
                $('#simpan').removeClass("disabled");
                Swal.hideLoading();
                Swal.fire('Ups','Ada kesalahan pada sistem','info');
                console.log(response);
            }
        });
    })

    function checkImageValid(){
        const img   = $('input[type="file"]')
        $.each(img, function(idx, value){
            file = value.files[0]
            if(value.name != 'img_usaha' || value.name == 'img_siub' && file == ''){
                Swal.fire('Maaf',`${value.alt} tidak boleh kosong`,'info');
                return false
            }
        })
    }

    function checkValidationFormUser(){
        const form = $('#submitData').serializeArray()
        $.each(form, function(index, value){
            if(value.name != 'note' && value.value == ''){
                Swal.fire('Maaf',`Data ${value.name.toUpperCase()} tidak boleh kosong`,'info');
                return false
            }else{
                return true
            }
        })
    }

    function checkImage(kategori){
        const file = document.querySelector(`input[id=${kategori}]`)
        const image = file.files[0]
        if(image.size > 2000000){
            Swal.fire('Ups','Maaf ukuran file maksimal hanya 2 MB','info');
        }else{
            $(`#${kategori}_review`).html(image.name)
        }
    }
</script>
@endpush
