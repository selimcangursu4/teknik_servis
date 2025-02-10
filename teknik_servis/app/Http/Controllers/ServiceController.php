<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\FaultCategories;
use App\Models\User;
use App\Models\Cities;
use App\Models\District;
use App\Models\Service;
use App\Models\ProductStatus;
use App\Models\ServicePriorityRequest;
use App\Models\WarrantyRecord;
use Yajra\DataTables\DataTables;
use App\Models\ServiceActivities;
use Illuminate\Support\Facades\DB;


class ServiceController extends Controller
{

    // TEKNİK SERVİS KAYITLARI SAYFASI
    public function index(){

        $users         = User::all();
        $products      = Product::all();
        $productStatus = ProductStatus::all();
        return view('service.index',compact('products','productStatus','users'));
    }


    // TEKNİK SERVİS KAYIT DETAY SAYFASI
    public function edit(Request $request , $id)
    {
        $service    = Service::where('service.id', $id)
        ->join('product', 'product.id', '=', 'service.product_id')
        ->join('product_colors', 'product_colors.id', '=', 'service.product_color_id')
        ->join('users', 'users.id', '=', 'service.referance_id')
        ->join('fault_categories', 'fault_categories.id', '=', 'service.fault_category_id')
        ->join('product_status','product_status.id','=','service.process_status_id')
        ->select('service.*', 'product.name as productName','product_colors.name as productColor',
        'users.name as userName','fault_categories.name as faultCategory','product_status.name as productStatus')
        ->first();
        $cities             = Cities::all();
        $districts          = District::all();
        $products           = Product::all();
        $service_activities = ServiceActivities::where('service_id','=',$service->id)->get();

        return view('service.edit',compact('service','cities','districts','products','service_activities'));
    }


    // SERVİS KAYDI DETAY BİLGİLERİNİ GÜNCELLEME
    public function update(Request $request){
        try {
            $record = Service::where('id','=',$request->input('service_id'));
            $record->update([
                'fullname'=>$request->input('fullname'),
                'land_phone'=>$request->input('land_phone'),
                'phone'=>$request->input('phone'),
                'imei'=>$request->input('imei'),
                'address'=>$request->input('address'),
                'city_id'=>$request->input('city_id'),
                'district_id'=>$request->input('district_id'),
                'product_id'=>$request->input('product_id'),
                'product_color_id'=>$request->input('product_color_id'),
            ]);
            return response()->json(['success'=>true,'message'=>'Kayıt Güncellendi']);
        } catch (Exception $error) {
            return response()->json(['success'=>true,'message'=>'Bilinmeyen Bir Hata' . ' ' . $error->getMessage()]);
        }
    }

    // YENİ SERVİS KAYDI EKLE SAYFASI
    public function create(){
        $users           = User::all();
        $cities          = Cities::all();
        $products        = Product::all();
        $faultCategories = FaultCategories::all();
        return view('service.create',compact('products','faultCategories','users','cities'));
    }

    // YENİ SERVİS KAYDI EKLE İŞLEMİ
    public function store(Request $request){
        try {
            // SERVİS KAYDI OLUŞTURMA
            $service = new Service();
            $service->fullname = $request->input('fullname');
            $service->phone = $request->input('phone');
            $service->alternative_phone = $request->input('alternative_phone');
            $service->land_phone = $request->input('land_phone');
            $service->email = $request->input('email');
            $service->city_id = $request->input('city_id');
            $service->district_id = $request->input('district_id');
            $service->address = $request->input('address');
            $service->product_id = $request->input('product_id');
            $service->product_color_id = $request->input('product_color_id');
            $service->imei = $request->input('imei');
            $service->warranty_status_id = $request->input('warranty_status_id');
            $service->invoice_date = $request->input('invoice_date');
            $service->fault_category_id = $request->input('fault_category_id');
            $service->fault_detail = $request->input('fault_detail');
            $service->service_priority_id = $request->input('service_priority_id');
            $service->referance_id = $request->input('referance_id');
            $service->user_id = 1;
            $service->process_status_id = 1;
            $service->save();

            // GARANTİ KAYDI OLUŞTURMA
            $warrantyStatus = new WarrantyRecord();
            $warrantyStatus->imei = $service->imei;
            $warrantyStatus->invoice_date = $service->invoice_date;
            $warrantyStatus->warranty_status_id = $service->warranty_status_id;
            $warrantyStatus->save();

            return response()->json(['success'=>true,'message'=>'Servis Kaydı Başarıyla Oluşturuldu !']);
        } catch (Exception $error) {
            return response()->json(['success'=>false,'message'=>'Bilinmeyen Bir Hata' . ' ' . $error->getMessage()]);
        }
    }
    
    // ÜRÜNE GÖRE RENKLERİN LİSTELENMESİ
    public function getProductColors(Request $request){
        $product_id = $request->input('product_id');
        $colors = ProductColor::where('product_id', $product_id)->get();
        return response()->json(['colors' => $colors]);
    }

    // İLE GÖRE İLÇELERIN LİSTELENMESİ
    public function getDistricts(Request $request)
    {
        $city_id = $request->input('cityId');
        $districts = District::where('sehirid', $city_id)->get();
    
        return response()->json(['districts' => $districts]);
    }

    // SERVİS ÜRÜNLERİNİN SERVERSİDE İLE DATATABLEDE LİSTELENMESİ
    public function fetch(Request $request)
    {
        $query = DB::table('service')
        ->join('product', 'product.id', '=', 'service.product_id')
        ->join('product_status','product_status.id','=','service.process_status_id')
        ->select('service.*', 'product.name as productName','product_status.name as productStatus')->get();
    
        if ($request->filled('search_service_id')) {
            $query->where('service.id', '=', $request->input('search_service_id'));
        }
        if ($request->filled('search_service_fullname')) {
            $query->where('service.fullname', 'LIKE', '%' . $request->input('search_service_fullname') . '%');
        }
        if ($request->filled('search_service_phone')) {
            $query->where('service.phone', '=', $request->input('search_service_phone'));
        }
        if ($request->filled('search_service_imei')) {
            $query->where('service.imei', '=', $request->input('search_service_imei'));
        }
        if ($request->filled('search_service_product_id')) {
            $query->where('service.product_id', '=', $request->input('search_service_product_id'));
        }
        if ($request->filled('search_service_product_status_id')) {
            $query->where('service.process_status_id', '=', $request->input('search_service_product_status_id'));
        }
        if ($request->filled('search_service_referance_id')) {
            $query->where('service.referance_id', '=', $request->input('search_service_referance_id'));
        }
        if ($request->filled('search_service_start_date')) {
            $query->whereDate('service.created_at', '>=', $request->input('search_service_start_date'));
        }
        if ($request->filled('search_service_end_date')) {
            $query->whereDate('service.created_at', '<=', $request->input('search_service_end_date'));
        }
    
        return DataTables::of($query)->make(true);
    }

    // SERVİS ÖNCELİK TALEBİ OLUŞTUR
    public function priorityRequest(Request $request)
    {
        try {
            
            $priority = new ServicePriorityRequest();
            $priority->service_id = $request->input('priority_service_id');
            $priority->priority_degree_id = $request->input('priority_degree');
            $priority->detail = $request->input('priority_detail');
            $priority->user_id = 1;
            $priority->status_id = 0;
            $priority->save();

            return response()->json(['success'=>true,'message'=>'Öncelik Talebi Oluşturuldu!']);
            
        } catch (Exception $error) {
            return response()->json(['success'=>false,'message'=>'Bilinmeyen Bir Hata' .''. $error->getMessage()]);
        }
    }
    
    // SERVİSTEKİ ÜRÜNÜN FATURA VEYA GARANTİ DURUMUNU GÜNCELLEME
    public function updateWarrantyStatus(Request $request)
    {
        try {
            $service = Service::where('id', $request->input('serviceId'))->first();
    
            if (!$service) {
                return response()->json(['success' => false, 'message' => 'Servis bulunamadı!']);
            }
            $service->invoice_date       = $request->input('invoice_date');
            $service->warranty_status_id = $request->input('warranty_status_id');
            $service->save();
    
            return response()->json(['success' => true, 'message' => 'Güncelleme Başarılı!']);
        } catch (Exception $error) {
            return response()->json(['success' => false, 'message' => 'Bilinmeyen Bir Hata: ' . $error->getMessage()]);
        }
    }
    
    // İMEİ SORGULAMA - ÜRÜNÜN DAHA ÖNCE SERVİSE GELİP GELMEDİĞİ BİLGİSİ
    public function checkImei(Request $request)
    {
        $service = Service::where('imei','=',$request->input('imei'))->first();

        if($service)
        {
            return response()->json(['success' => true, 'message' => 'Bu İmeili Ürün Daha Önce Servise Gelmiştir.']);
        }else{
            return response()->json(['success' => false, 'message' =>'Bu Ürün İlk Defa Servise Gelmiştir!']);
        }
    }

    // İMEİ İLE ÜRÜNÜN GARANTİ VE FATURA BİLGİSİNİ GİRİŞ EKRANINDA GÖSTERİMİ

    public function getWarrantyAndInvoice(Request $request)
    {
        $warranty_record    = WarrantyRecord::where('imei','=',$request->input('imei'))->first();
        $warranty_status_id = $warranty_record->warranty_status_id;
        $invoice_date       = $warranty_record->invoice_date;

        if($warranty_record)
        {
            return response()->json(['success'=>true , 'warranty_status_id'=>$warranty_status_id,'invoice_date'=>$invoice_date]);
        }
    }


    // SERVİS KAYDINI SİLME 

    public function delete(Request $request )
    {
        try {
            $service = Service::where('id','=',$request->input('id'))->first();

            if (!$service) {
                return response()->json(['success' => false,'message' => 'Servis bulunamadı!']);
            }

            $service->delete();

            return response()->json(['success' => true,'message' => 'Servis Kaydı Silindi!']);
        } catch (Exception $error) {
            return response()->json(['success'=>false,'message'=>'Bilinmeyen Bir Hata'.''. $error->getMessage()]);
        }
    }

    
}