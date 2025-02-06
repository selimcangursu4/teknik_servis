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
use Yajra\DataTables\DataTables;
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
        ->select('service.*', 'product.name as productName')->get();
    
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
    

    
}