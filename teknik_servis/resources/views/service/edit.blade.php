@extends('partials.master')
@section('main')
    <div class="row">
        <div class="col-md-8">
            <h5>Servis Numarası : {{ $service->id }}</h5>
            <!-- Ürün Acilyet Durumuna Göre Alert Listesi -->
            @if ($service->service_priority_id == 1)
                <div class="alert alert-primary text-center" role="alert">
                    <small>Bu Servis Kaydı <b>Normal</b> Seviyededir.</small>
                </div>
            @elseif($service->service_priority_id == 2)
                <div class="alert alert-danger text-center" role="alert">
                    <small>Bu Servis Kaydı <b>Acil</b> Seviyededir.</small>
                </div>
            @elseif($service->service_priority_id == 3)
                <div class="alert alert-warning text-center" role="alert">
                    <small>Bu Servis Kaydı <b>Yüksek</b> Seviyededir.</small>
                </div>
            @endif
            <!-- Ürün Acilyet Durumuna Göre Alert Listesi :: Son -->
            <!-- Teknik Servis Detayları -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">Teknik Servis Detayları</h5>
                </div>
                <div class="card-body">
                    <!-- Servise Alındı -->
                    @if ($service->process_status_id == 1)
                        <button id="getProcessedButton" class="btn btn-success">Cihazı İşleme Al</button>
                    @endif
                    <!-- İşlemde -->
                    @if ($service->process_status_id == 2)
                        <button class="btn btn-success takeControlButton">Cihazı Kontrole Al</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#createPaymentModal">
                            Ödeme Tutarı Oluştur
                        </button>
                        <button class="btn btn-warning noFaultButton">Sorun Bulunamadı</button>
                    @endif
                    <!-- Kontrolde -->
                    @if ($service->process_status_id == 3)
                        <button class="btn btn-success ControlChecked">Cihaz Kontrol Edildi</button>
                    @endif
                    <!-- Kontrol Edildi -->
                    @if ($service->process_status_id == 4)
                        <button class="btn btn-success takeDelivery">Cihazı Kargola ve İşlemleri Tamamla</button>
                    @endif
                    <!-- Ödeme Bekleniyor -->
                    @if ($service->process_status_id == 6)
                        <button id="cancelPaymentButton" class="btn btn-success">Ödemeyi İptal Et</button>
                    @endif
                    <!-- Ödeme İptal Edildi -->
                    @if ($service->process_status_id == 7)
                        <button class="btn btn-success takeControlButton">Cihazı Kontrole Al</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#createPaymentModal">
                            Ödeme Tutarı Oluştur
                        </button>
                        <button class="btn btn-warning noFaultButton">Sorun Bulunamadı</button>
                    @endif
                    @if ($service->process_status_id == 8)
                        <button class="btn btn-success takeDelivery">Cihazı Kargola ve İşlemleri Tamamla</button>
                    @endif
                    @if ($service->process_status_id == 9)
                        <button class="btn btn-success takeDelivery">Cihazı Kargola ve İşlemleri Tamamla</button>
                    @endif
                    <hr>
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th scope="row">Servis Türü :</th>
                                <td>Servis Ürünü</td>
                            </tr>
                            <tr>
                                <th scope="row">Ürün Modeli :</th>
                                <td>{{ $service->productName }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ürün Rengi :</th>
                                <td>{{ $service->productColor }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Seri Numarası :</th>
                                <td>{{ $service->imei }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Garanti Durumu :</th>
                                @if ($service->warranty_status_id == 1)
                                    <td>Garanti Var</td>
                                @elseif($service->warranty_status_id == 2)
                                    <td>Garanti Yok</td>
                                @elseif($service->warranty_status_id == 3)
                                    <td>Belirtilmedi</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">Temsilci Personel :</th>
                                <td>{{ $service->userName }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kargo Teslim Tipi :</th>
                                <td>Yurtiçi Kargo Vb</td>
                            </tr>
                            <tr>
                                <th scope="row">Servise Geliş Tarihi :</th>
                                <td>{{ $service->created_at }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Arıza Kategorisi :</th>
                                <td>{{ $service->faultCategory }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Servis Durumu :</th>
                                <td>{{ $service->productStatus }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tamamlanma Tarihi :</th>
                                <td>{{ $service->completion_date }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Teknik Servis Detayları::Son -->
            <!-- Teknik Servis İşlem Geçmişi -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Servis İşlem Detayları</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Detay</th>
                                <th scope="col">Personel</th>
                                <th scope="col">Durum</th>
                                <th scope="col">Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service_activities as $activities)
                                <tr>
                                    <td scope="row">{{ $activities->id }}</td>
                                    <td>{{ $activities->detail }}</td>
                                    <td>{{ $activities->userName }}</td>
                                    <td>{{ $activities->processStatus }}</td>
                                    <td>{{ $activities->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Müşteri Bilgileri</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">* Müşteri İsim Soyisim</h5>
                    <p class="card-text">{{ $service->fullname }}</p>
                    <h5 class="card-title">* Müşteri Cep Telefonu</h5>
                    <p class="card-text">{{ $service->phone }}</p>
                    <h5 class="card-title">* Müşteri Alternatif Cep Telefonu</h5>
                    <p class="card-text">{{ $service->alternative_phone }}</p>
                    <h5 class="card-title">* Müşteri Sabit Numarası</h5>
                    <p class="card-text">{{ $service->land_phone }}</p>
                    <h5 class="card-title">* Müşteri E-Posta Adresi</h5>
                    <p class="card-text">{{ $service->email }}</p>
                    <h5 class="card-title">* Müşteri Adres Bilgisi</h5>
                    <p class="card-text">{{ $service->address }}</p>
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                        data-bs-target="#detail_modal">
                        Detaylar
                    </button>
                    <button type="button" class="btn btn-warning w-100 mt-1" data-bs-toggle="modal"
                        data-bs-target="#send_sms_modal">
                        Sms Gönder
                    </button>
                    <button type="button" class="btn btn-danger mt-1 w-100" data-bs-toggle="modal"
                        data-bs-target="#service_priority_request">
                        Servis Öncelik Talebi
                    </button>
                    <button class="w-100 btn btn-secondary mt-1">Teknik Servis Formu Yazdır</button>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    <h5 class="card-title">Fatura ve Garanti Durumu</h5>
                </div>
                <div class="card-body">
                    <small class="card-text">İlgili Cihazın Fatura ve Garanti Durumunu Bu Alandan
                        Değiştrebilirsiniz.</small>
                    <button type="button" class="btn btn-secondary mt-1" data-bs-toggle="modal"
                        data-bs-target="#invoice_update">
                        Fatura ve Garanti Durumunu Güncelle
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Detaylar Modal -->
    <div class="modal fade" id="detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Kayıt Bilgilerini Güncelle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Müşteri İsim Soyisim*</b></label>
                                    <input type="text" class="form-control" id="fullname"
                                        value="{{ $service->fullname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Sabit Telefon*</b></label>
                                    <input type="text" class="form-control" id="land_phone"
                                        value="{{ $service->land_phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Cep Telefonu*</b></label>
                                    <input type="text" class="form-control" id="phone"
                                        value="{{ $service->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Seri Numarası*</b></label>
                                    <input type="text" class="form-control" id="imei"
                                        value="{{ $service->imei }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label"><b>Adres Bilgisi*</b></label>
                                    <textarea class="form-control" id="address" rows="3">{{ $service->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Şehir*</b></label>
                                    <select class="form-select" aria-label="Seçiniz..." id="city_id">
                                        <option selected>Seçiniz...</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $service->city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->sehiradi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>İlçe</b></label>
                                    <select class="form-select" aria-label="Seçiniz..." id="district_id">
                                        <option selected>Seçiniz...</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $service->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->ilceadi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Ürün*</b></label>
                                    <select class="form-select" aria-label="Seçiniz..." id="product_id">
                                        <option selected>Seçiniz...</option>
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product->id }}"{{ $service->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><b>Ürün Rengi*</b></label>
                                    <select class="form-select" aria-label="Seçiniz..." id="product_color_id">
                                        <option selected>Seçiniz...</option>
                                        <option value="1"
                                            {{ in_array($service->product_color_id, range(1, 10)) ? 'selected' : '' }}>
                                            Mavi
                                        </option>
                                        <option value="2"
                                            {{ in_array($service->product_color_id, range(11, 20)) ? 'selected' : '' }}>
                                            Pembe
                                        </option>
                                        <option value="3"
                                            {{ in_array($service->product_color_id, range(21, 30)) ? 'selected' : '' }}>
                                            Siyah
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" id="updateServiceRecordButton" class="btn btn-primary">Güncelle</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sms Gönder Modal -->
    <div class="modal fade" id="send_sms_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sms Gönder</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label"><b>Telefon Numarası</b></label>
                            <input type="text" class="form-control" id="sms_phone" disabled
                                value="{{ $service->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Mesaj</b></label>
                            <textarea class="form-control" id="sms_message" rows="5"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            <button type="button" id="sendSmsButton" class="btn btn-primary">Sms Gönder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Servis Öncelik Talebi Modal -->
    <div class="modal fade" id="service_priority_request" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Servis Öncelik Talebi Oluştur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label"><b>Servis Numarası</b></label>
                            <input type="text" class="form-control" id="priority_service_id" disabled
                                value="{{ $service->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Öncelik Derecesi</b></label>
                            <select class="form-select" id="priority_degree" aria-label="Seçiniz...">
                                <option selected>Seçiniz...</option>
                                <option value="1">Normal</option>
                                <option value="2">Yüksel</option>
                                <option value="3">Acil</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Öncelik Talep Detayı</b></label>
                            <textarea class="form-control" id="priority_detail" rows="5"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            <button type="button" id="sendPriorityRequestButton" class="btn btn-primary">Öncelik Talebi
                                Gönder</button>
                        </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fatura ve Garanti Bilgisi Güncelle Modal -->
    <div class="modal fade" id="invoice_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Fatura ve Garanti Durumu Güncelle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Fatura Tarihi</label>
                            <input type="date" class="form-control" id="invoice_date"
                                value="{{ $service->invoice_date }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Garanti Durumu</label>
                            <select class="form-select" id="warranty_status_id" aria-label="Seçiniz...">
                                <option selected>Seçiniz...</option>
                                <option value="1" {{ $service->warranty_status_id == 1 ? 'selected' : '' }}>Garanti
                                    Var</option>
                                <option value="2" {{ $service->warranty_status_id == 2 ? 'selected' : '' }}>Garanti
                                    Yok</option>
                                <option value="3" {{ $service->warranty_status_id == 3 ? 'selected' : '' }}>
                                    Belirlenemedi</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            <button type="button" id="invoiceUpdateButton" class="btn btn-primary">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Ödeme Tutarı Oluştur Modal-->
    <div class="modal fade" id="createPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ödeme Tutarı Oluştur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Ödeme Tutarı</label>
                            <input type="number" class="form-control" id="payment_amount"
                                placeholder="Ödeme Tutarı Giriniz" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ödeme Detayı</label>
                            <textarea class="form-control" id="payment_detail" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            <button type="button" class="btn btn-primary createPaymentButton">Ödeme Oluştur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    searching: false
                });

                // Servis Detaylar Modülü İçeriği Güncelleme
                $('#updateServiceRecordButton').click(function(e) {
                    e.preventDefault();

                    let fullname = $('#fullname').val();
                    let land_phone = $('#land_phone').val();
                    let phone = $('#phone').val();
                    let imei = $('#imei').val();
                    let address = $('#address').val();
                    let city_id = $('#city_id').val();
                    let district_id = $('#district_id').val();
                    let product_id = $('#product_id').val();
                    let product_color_id = $('#product_color_id').val();
                    let service_id = "{{ $service->id }}";

                    $.ajax({
                        type: "POST",
                        url: "{{ route('service.update') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            service_id: service_id,
                            fullname: fullname,
                            land_phone: land_phone,
                            phone: phone,
                            imei: imei,
                            address: address,
                            city_id: city_id,
                            district_id: district_id,
                            product_id: product_id,
                            product_color_id: product_color_id
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
                                    icon: "success",
                                    title: response.message,
                                    showConfirmButton: true,
                                });
                            }
                        }
                    })
                });
                // SMS Gönder
                $('#sendSmsButton').click(function(e) {
                    e.preventDefault();

                    let smsPhone = $('#sms_phone').val();
                    let smsMessage = $('#sms_message').val();
                    let serviceId = "{{ $service->id }}";

                    $.ajax({
                        type: "POST",
                        url: "{{ route('sms.send') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            serviceId: serviceId,
                            smsPhone: smsPhone,
                            smsMessage: smsMessage
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log(response.message);
                                Swal.fire({
                                    icon: "success",
                                    title: response.message,
                                    confirmButtonText: "Tamam"
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
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: "error",
                                title: "Beklenmedik bir hata oluştu!",
                                text: xhr.responseText
                            });
                        }
                    });
                });
                // Servis Öncelik Talebi Modülü
                $('#sendPriorityRequestButton').click(function(e) {
                    let priority_service_id = $('#priority_service_id').val();
                    let priority_degree = $('#priority_degree').val();
                    let priority_detail = $('#priority_detail').val();
                    $.ajax({
                        type: "post",
                        url: "{{ route('service.priorityRequest') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            priority_service_id: priority_service_id,
                            priority_degree: priority_degree,
                            priority_detail: priority_detail
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
                // Fatura ve Garanti Durumu Güncelle
                $('#invoiceUpdateButton').click(function(e) {
                    e.preventDefault();

                    let invoice_date = $('#invoice_date').val();
                    let warranty_status_id = $('#warranty_status_id').val();
                    let serviceId = "{{ $service->id }}";

                    $.ajax({
                        type: "post",
                        url: "{{ route('service.updateWarrantyStatus') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            serviceId: serviceId,
                            invoice_date: invoice_date,
                            warranty_status_id: warranty_status_id
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
                // Cihazı İşleme Al Butonu 
                $('#getProcessedButton').click(function(e) {
                    e.preventDefault();
                    Swal.fire({
                        icon: "warning",
                        title: "Cihazı İşleme Almak İstediğinize Emin misiniz ?",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "Cihazı İşleme Al",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let service_id = "{{ $service->id }}";
                            console.log(service_id);
                            $.ajax({
                                type: "POST",
                                url: "{{ route('service.getProcessed') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    service_id: service_id
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
                        }
                    });
                })
                // Cihazı Kontrole Al Butonu
                $('.takeControlButton').click(function(e) {
                    e.preventDefault();
                    let serviceId = "{{ $service->id }}";

                    Swal.fire({
                        icon: "warning",
                        title: "Cihazı Kontrole Almak İstediğine Eminmisin ? ",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "Cihazı Kontrole Al",
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "POST",
                                url: "{{ route('service.takeControl') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    serviceId: serviceId
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
                        }
                    });
                })
                // Kontrol Edildi Butonu
                $('.ControlChecked').click(function(e) {
                    e.preventDefault();
                    let serviceId = "{{ $service->id }}";

                    Swal.fire({
                        icon: "warning",
                        title: "Cihazın Kontrol Edildiğine Emin misiniz ?  ? ",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "Cihaz Kontrol Edildi",
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "POST",
                                url: "{{ route('service.controlChecked') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    serviceId: serviceId
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
                        }
                    });
                })
                // Cihazı Kargola Butonu
                $('.takeDelivery').click(function(e) {
                    e.preventDefault();
                    let serviceId = "{{ $service->id }}";

                    Swal.fire({
                        icon: "warning",
                        title: "Cihazın Kargolamak İstediğine Emin misiniz ?  ? ",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "Evet,Cihazı Kargola!",
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "POST",
                                url: "{{ route('service.takeDelivery') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    serviceId: serviceId
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
                        }
                    });
                })
                // Ödeme Tutarı Oluştur 
                $('.createPaymentButton').click(function(e) {
                    e.preventDefault();
                    let serviceId = "{{ $service->id }}";
                    let amount = $('#payment_amount').val();
                    let payment_detail = $('#payment_detail').val();

                    $.ajax({
                        type: "POST",
                        url: '{{ route('service.createPayment') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            serviceId: serviceId,
                            amount: amount,
                            payment_detail: payment_detail
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

                $('#cancelPaymentButton').click(function(e) {
                    e.preventDefault();

                    let service_id = "{{ $service->id }}";
                    $.ajax({
                        type: "POST",
                        url: "{{ route('service.cancelPayment') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            service_id: service_id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Ödemeyi iptal etmek istediğinize emin misiniz?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Evet, iptal et",
                                cancelButtonText: "Hayır, vazgeç"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (response.success) {
                                        console.log(response.message);
                                        Swal.fire({
                                            icon: "success",
                                            title: "Ödeme iptal edildi!",
                                            showConfirmButton: true
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        console.log(response.message);
                                        Swal.fire({
                                            position: "top-center",
                                            icon: "error",
                                            title: response.message,
                                            showConfirmButton: true
                                        });
                                    }
                                }
                            });
                        }

                    })
                })
                // Sorun Görülemedi Butonu
                $('.noFaultButton').click(function(e) {
                    e.preventDefault();
                    let serviceId = "{{ $service->id }}";
                    $.ajax({
                        type: "post",
                        url: "{{ route('service.noFault') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            serviceId: serviceId
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Sorun görülmediğine emin misiniz?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Evet, eminim",
                                cancelButtonText: "Hayır, vazgeç"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (response.success) {
                                        console.log(response.message);
                                        Swal.fire({
                                            icon: "success",
                                            title: "Cihazda sorun görülemedi!",
                                            showConfirmButton: true
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        console.log(response.message);
                                        Swal.fire({
                                            position: "top-center",
                                            icon: "error",
                                            title: response.message,
                                            showConfirmButton: true
                                        });
                                    }
                                }
                            });
                        }

                    })
                })
            })
        </script>
    @endsection
