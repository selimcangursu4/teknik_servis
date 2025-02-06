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
                    <small class="form-label"><b>Servis Numarası:</b></small>
                    <input type="text" class="form-control" id="search-service-id" name="search-service-id">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <small class="form-label"><b>Müşteri Adı Soyadı:</b></small>
                    <input type="text" class="form-control" id="search-service-fullname" name="search-service-fullname">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <small  class="form-label"><b>Cep Telefon Numarası:</b></small>
                    <input type="text" class="form-control" id="search-service-phone" name="search-service-phone">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <small class="form-label"><b>Imeı Numarası:</b></small>
                    <input type="text" class="form-control" id="search-service-imei" name="search-service-imei">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <small class="form-label"><b>Ürün Modeli:</b></small>
                    <input type="text" class="form-control" id="search-service-product-id" name="search-service-product-id">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <small class="form-label"><b>Ürün Durumu:</b></small>
                    <input type="text" class="form-control" id="search-service-product-status-id" name="search-service-product-status-id">
                  </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <small class="form-label"><b>Temsilci:</b></small>
                    <input type="text" class="form-control" id="search-service-referance-id" name="search-service-referance-id">
                  </div>
            </div> 
            <div class="col-md-3">
                <div class="mb-3">
                    <small class="form-label"><b>Servis Tarih Aralığı:</b></small>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control" id="search-service-start-date" name="search-service-start-date" aria-describedby="basic-addon1">
                        <input type="date" class="form-control" id="search-service-end-date" name="search-service-end-date" aria-describedby="basic-addon1">
                      </div> 
                  </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-warning float-end">Sonuçları Detaylı Filtrele</button>
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
        <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Ad ve Soyad</th>
                <th scope="col">Telefon</th>
                <th scope="col">Cihaz</th>
                <th scope="col">İmei</th>
                <th scope="col">Cihaz Durumu</th>
                <th scope="col">Servis Tarihi</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">1</td>
                <td>Selimcan Gürsu</td>
                <td>5550162190</td>
                <td>Wiky Watch 4G</td>
                <td>355800110104472</td>
                <td>Servise Alındı	</td>
                <td>10/02/2023</td>
                <td><button class="btn btn-primary">Detay</button></td>
              </tr>
            </tbody>
          </table>
    </div>
  </div>
@endsection