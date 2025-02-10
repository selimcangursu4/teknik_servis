@extends('partials.master')
@section('main')
<div class="card">
    <div class="card-header">
      <h5>Detaylı Arama</h5>
    </div>
    <div class="card-body">
       <form>
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Servis Numarası:</b></label>
                    <input type="text" class="form-control" id="search-service-id" name="search-service-id" placeholder="Servis Numarası Giriniz..">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Müşteri Adı Soyadı:</b></label>
                    <input type="text" class="form-control" id="search-service-fullname" name="search-service-fullname" placeholder="Müşteri Ad Soyad Giriniz...">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label  class="form-label"><b>Cep Telefon Numarası:</b></label>
                    <input type="text" class="form-control" id="search-service-phone" name="search-service-phone" placeholder="Cep Telefon Numarası Giriniz...">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Imeı Numarası:</b></label>
                    <input type="text" class="form-control" id="search-service-imei" name="search-service-imei" placeholder="Cihaz İmei Numarasını Giriniz..">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Ürün Modeli:</b></label>
                    <select class="form-select" id="search-service-product-id" name="search-service-product-id" aria-label="Seçiniz..">
                      <option>Seçiniz...</option>
                      @foreach($products as $product)
                      <option value="{{$product->id}}">{{$product->name}}</option>
                      @endforeach
                    </select>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Ürün Durumu:</b></label>
                    <select class="form-select" id="search-service-product-status-id" name="search-service-product-status-id" aria-label="Seçiniz..">
                      <option>Seçiniz...</option>
                      @foreach($productStatus as $status)
                      <option value="{{$status->id}}">{{$status->name}}</option>
                      @endforeach
                    </select>
                 
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Temsilci:</b></label>
                    <select class="form-select" id="search-service-referance-id" name="search-service-referance-id" aria-label="Seçiniz..">
                      <option>Seçiniz...</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                  </div>
            </div> 
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><b>Servis Tarih Aralığı:</b></label>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control" id="search-service-start-date" name="search-service-start-date" aria-describedby="basic-addon1">
                        <input type="date" class="form-control" id="search-service-end-date" name="search-service-end-date" aria-describedby="basic-addon1">
                      </div> 
                  </div>
              </div>
            <div class="col-md-12">
                <button type="button" id="filterServiceButton" class="btn btn-warning float-end">Sonuçları Detaylı Filtrele</button>
            </div>
        </div>
       </form>
    </div>
  </div>
  <div class="card mt-5">
    <div class="card-header">
      <h5>Müşteri ve Veri Yönetimi</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover" id="myTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Ad ve Soyad</th>
                <th scope="col">Telefon</th>
                <th scope="col">Cihaz</th>
                <th scope="col">İmei</th>
                <th scope="col">Cihaz Durumu</th>
                <th scope="col">Servis Tarihi</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
    </div>
  </div>
  <script>
   $(document).ready(function(){
    let table = new DataTable('#myTable', {
        serverSide: true,
        processing: true,
        searching:false,
        ajax: {
            type: "GET",
            url: "/service/fetch",
            data: function(d){
                d.search_service_id                = $('#search-service-id').val();
                d.search_service_fullname          = $('#search-service-fullname').val();
                d.search_service_phone             = $('#search-service-phone').val();
                d.search_service_imei              = $('#search-service-imei').val();
                d.search_service_product_id        = $('#search-service-product-id').val();
                d.search_service_product_status_id = $('#search-service-product-status-id').val();
                d.search_service_referance_id      = $('#search-service-referance-id').val();
                d.search_service_start_date        = $('#search-service-start-date').val();
                d.search_service_end_date          = $('#search-service-end-date').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'fullname', name: 'fullname' },
            { data: 'phone', name: 'phone' },
            { data: 'productName', name: 'productName' },
            { data: 'imei', name: 'imei' },
            { data: 'productStatus', name: 'productStatus' },
            { 
                data: 'created_at', 
                name: 'created_at', 
                render: function(data) {
                    return moment(data, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY HH:mm:ss");
                } 
            },
            { 
                data: 'action', 
                name: 'action',
                render: function(data, type, row) {
                    return `<a href="/service/edit/${row.id}" class="btn btn-primary btn-sm">İncele</a> <button class='btn btn-danger deleteRecord btn-sm' data-id=${row.id}>Sil</button>`;
                }
            }
        ]
    });
    // Filtreleme Butonuna Basıldığında
    $('#filterServiceButton').click(function(e){
      e.preventDefault();
      table.draw();
    })
    // Kayıt Silme İşlemi
    $(document).on('click','.deleteRecord',function(e){
      e.preventDefault();
      let id = $(this).data('id');
      Swal.fire({
        title: 'Silmek istediğinizden emin misiniz?',
        text: "Kaydı silmek istediğinizden emin misiniz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Evet, sil!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '/service/delete/',
            type: 'POST',
            data:{
              id: id,
              _token: '{{csrf_token()}}'
            },
            success: function(response) {
              Swal.fire(
                'Silindi!',
                'Kaydınız başarıyla silindi.',
                'success'
              )
              table.draw();
            }
          });
        }
      });
    })
});

  </script>
@endsection