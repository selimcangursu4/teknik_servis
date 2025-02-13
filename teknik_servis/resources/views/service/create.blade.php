@extends('partials.master')
@section('main')
    <div class="card">
        <div class="card-header">
            <h5>Yeni Servis Kaydı Ekleme Formu</h5>
        </div>
        <div class="card-body">
            <form>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Müşteri Ad Soyad:</b></label>
                            <input type="text" class="form-control" id="fullname"
                                placeholder="Müşteri İsim Soyismini Giriniz...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Telefon Numarası:</b></label>
                            <input type="text" class="form-control" id="phone"
                                placeholder="Müşteri Telefon Numarası Giriniz...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Alternatif Cep Telefonu:</b></label>
                            <input type="text" class="form-control" id="alternative_phone"
                                placeholder="Alternatif Cep Telefon Numarası Giriniz...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Sabit Telefon:</b></label>
                            <input type="text" class="form-control" id="land_phone"
                                placeholder="Sabit Telefon Numarası Giriniz...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>E-Posta Adresi:</b></label>
                            <input type="email" class="form-control" id="email"
                                placeholder="Müşteri E-Posta Adresi Giriniz...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Şehir:</b></label>
                            <select class="form-select" id="city_id" required aria-label="Seçiniz...">
                                <option>Seçiniz..</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->sehiradi }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>İlçe:</b></label>
                            <select class="form-select" required id="district_id" aria-label="Seçiniz..">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><b>Adres Bilgisi:</b></label>
                            <textarea class="form-control" id="address" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Ürün Bilgisi:</b></label>
                            <select class="form-select" required id="product_id" aria-label="Seçiniz..">
                                <option>Seçiniz...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Ürün Rengi:</b></label>
                            <select class="form-select" required id="product_color_id" aria-label="Seçiniz..">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Seri Numarası:</b></label>
                            <input type="text" class="form-control" id="imei">
                            <div class="alert alert-warning mt-2 d-flex align-items-center" role="alert"
                                id="imeiCheckArea" style="display: none !important">
                                <i class="fa-solid fa-triangle-exclamation"></i> <small id="imeiCheck"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Garanti Durumu:</b></label>
                            <select class="form-select" required id="warranty_status_id" aria-label="Seçiniz..">
                                <option>Seçiniz...</option>
                                <option value="1">Garanti Var</option>
                                <option value="2">Garanti Yok</option>
                                <option value="3">Belirtilmedi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Fatura Tarihi:</b></label>
                            <input type="date" class="form-control" id="invoice_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Arıza Kategorisi:</b></label>
                            <select class="form-select" required id="fault_category_id" aria-label="Seçiniz..">
                                <option>Seçiniz...</option>
                                @foreach ($faultCategories as $faultCategory)
                                    <option value="{{ $faultCategory->id }}">{{ $faultCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><b>Arıza Açıklaması:</b></label>
                            <textarea class="form-control" id="fault_detail" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Servis Önceliği:</b></label>
                            <select class="form-select" required id="service_priority_id" aria-label="Seçiniz..">
                                <option>Seçiniz...</option>
                                <option value="1">Normal</option>
                                <option value="2">Acil</option>
                                <option value="3">Yüksek</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><b>Referans Durumu:</b></label>
                            <select class="form-select" id="referance_id" aria-label="Seçiniz..">
                                <option>Seçiniz...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="save" class="btn btn-primary float-end">Yeni Servis Kaydı
                            Oluştur</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {


            // Yeni Servis Kaydı Oluştur
            $('#save').click(function(e) {

                e.preventDefault();
                let fullname = $('#fullname').val();
                let phone = $('#phone').val();
                let alternative_phone = $('#alternative_phone').val();
                let land_phone = $('#land_phone').val();
                let email = $('#email').val();
                let city_id = $('#city_id').val();
                let district_id = $('#district_id').val();
                let address = $('#address').val();
                let product_id = $('#product_id').val();
                let product_color_id = $('#product_color_id').val();
                let imei = $('#imei').val();
                let warranty_status_id = $('#warranty_status_id').val();
                let invoice_date = $('#invoice_date').val();
                let fault_category_id = $('#fault_category_id').val();
                let fault_detail = $('#fault_detail').val();
                let service_priority_id = $('#service_priority_id').val();
                let referance_id = $('#referance_id').val();

                $.ajax({

                    type: "POST",
                    url: "{{ route('service.store') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        fullname: fullname,
                        phone: phone,
                        alternative_phone: alternative_phone,
                        land_phone: land_phone,
                        email: email,
                        city_id: city_id,
                        district_id: district_id,
                        address: address,
                        product_id: product_id,
                        product_color_id: product_color_id,
                        imei: imei,
                        warranty_status_id: warranty_status_id,
                        invoice_date: invoice_date,
                        fault_category_id: fault_category_id,
                        fault_detail: fault_detail,
                        service_priority_id: service_priority_id,
                        referance_id: referance_id
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message);
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showDenyButton: false,
                                showCancelButton: true,
                                confirmButtonText: "Tamam",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            console.log(response.message);
                            Swal.fire({
                                position: "top-center",
                                icon: "error",
                                title: response.message,
                                showConfirmButton: true,
                            });
                        }
                    }
                })
            })

            // Ürüne Göre Renklerin Listelenmesi
            $('#product_id').change(function(e) {
                e.preventDefault();
                let product_id = $(this).val();
                let url = "{{ route('getProductColors') }}";

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        let options = '';
                        $.each(response.colors, function(index, color) {
                            options += '<option value="' + color.id + '">' + color
                                .name + '</option>';
                        });
                        $('#product_color_id').html(options);
                    }
                });
            });
            // İle Göre İlçelerin Listelenmesi
            $('#city_id').change(function(e) {
                e.preventDefault();
                let cityId = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('getDistricts') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        cityId: cityId
                    },
                    success: function(response) {
                        let options = '';
                        $.each(response.districts, function(index, district) {
                            options += '<option value="' + district.id + '">' + district
                                .ilceadi + '</option>';
                        });
                        $('#district_id').html(options);
                    }
                });
            });
            // İmei Sorgulama  - Daha Önce Servise Gelip Gelmediği

            $('#imei').change(function(e) {
                e.preventDefault();
                let imei = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('checkImei') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        imei: imei
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#imeiCheckArea').css('display', 'block');
                            $('#imeiCheck').html(response.message)
                        } else {
                            $('#imeiCheckArea').css('display', 'block');
                            $('#imeiCheck').html(response.message)
                        }
                    }
                })
            })
            // İmei Bilgisine Göre Garanti Durumu ve Fatura Tarihi Güncellemesi
            $('#imei').change(function(e) {
                e.preventDefault();
                let imei = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('getWarrantyAndInvoice') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        imei: imei
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#warranty_status_id').val(response.warranty_status_id)
                            $('#invoice_date').val(response.invoice_date);
                            $('#warranty_status_id').attr('disabled', 'true');
                            $('#invoice_date').attr('disabled', 'true');
                        }
                    }
                })
            })
            // Telefon Numarasını 10 Haneli Kısıtlama
            $('#phone').change(function(e){
                e.preventDefault();
                let phone = $(this).val();
                let formattedPhone = phone.replace(/[^0-9]/g, '');
                if(formattedPhone.length >= 10){
                    formattedPhone = formattedPhone.substr(0, 10);
                }
                $('#phone').val(formattedPhone);
            })
            // Alternatif Telefon Numarasını 10 Haneli Kısıtlama
            $('#alternative_phone').change(function(e){
                e.preventDefault();
                let alternative_phone = $(this).val();
                let formattedAlternativePhone = alternative_phone.replace(/[^0-9]/g, '');
                if(formattedAlternativePhone.length >= 10){
                    formattedAlternativePhone = formattedAlternativePhone.substr(0, 10);
                }
                $('#alternative_phone').val(formattedAlternativePhone);
            })
            // Sabit Telefon Numarasını 10 Haneli Kısıtlama
            $('#land_phone').change(function(e){
                e.preventDefault();
                let land_phone = $(this).val();
                let formattedLandPhone = land_phone.replace(/[^0-9]/g, '');
                if(formattedLandPhone.length >= 10){
                    formattedLandPhone = formattedLandPhone.substr(0, 10);
                }
                $('#land_phone').val(formattedLandPhone);
            })
        })
    </script>
@endsection
