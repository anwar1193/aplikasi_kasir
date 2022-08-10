<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\BuyDetail;
use App\Models\Buy;

class BuyDetailController extends Controller
{
    public function index()
    {
        $buy_id = session('buy_id'); // supaya data buy_id dari form buy bisa di teruskan,maka ditampung dulu di session
        $product = Product::orderBy('product_name')->get();
        $supplier = Supplier::find(session('supplier_id'));
        $buy_detail = BuyDetail::where('buy_id', $buy_id)->orderBy('id')->get();

        if(!$supplier){
            abort(404);
        }

        return view('buy_detail.index', [
            'title' => 'transaction | buy_detail',
            'buy_id' => $buy_id,
            'product' => $product,
            'supplier' => $supplier,
            'buy_detail' => $buy_detail
        ]);
    }

    public function buyDetailAdd(Request $request)
    {
        $buyDetail = new BuyDetail();
        $buyDetail->buy_id = $request->buy_id;
        $buyDetail->product_id = $request->product_id;
        $buyDetail->product_name = $request->product_name;
        $buyDetail->price = $request->price;
        $buyDetail->quantity = $request->quantity;
        $buyDetail->sub_total = $request->sub_total;
        $buyDetail->save();

        $buyDetail->product_code = $request->product_code;

        return response()->json($buyDetail);
    }

    public function buyDetailDelete($id)
    {
        $buyDetail = BuyDetail::find($id);
        $buyDetail->delete();

        return response()->json(['success' => 'Data has been deleted!']);
    }

    public function buyDetailUpdate(Request $request)
    {
        $quantity = $request->qty;
        $price = $request->price;
        $sub_total = $quantity * $price;

        $buyDetail = BuyDetail::find($request->id);
        $buyDetail->quantity = $quantity;
        $buyDetail->sub_total = $sub_total;
        $buyDetail->save();

        return response()->json($buyDetail);
    }

    public function buyDetailUpdateFinal(Request $request)
    {
        $buy = Buy::find($request->buy_id);
        $buy->total_harga = $request->total_harga;
        $buy->diskon = $request->diskon;
        $buy->total_bayar = $request->total_bayar;
        $buy->update();

        // Update Quantity di table products
        $buyDetail = BuyDetail::where('buy_id', $request->buy_id)->get();

        foreach($buyDetail as $data){
            $product = Product::find($data['product_id']);
            $product->stock += $data['quantity'];
            $product->update();
        }

        return response()->json('Transaksi Pembelian Berhasil');
        
    }
}
