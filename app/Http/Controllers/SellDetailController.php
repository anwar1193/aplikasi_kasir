<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Member;
use App\Models\Sell;
use App\Models\SellDetail;

class SellDetailController extends Controller
{
    public function index()
    {
        $sell_id = session('sell_id');
        $product = Product::orderBy('product_name')->get();
        $member = Member::orderBy('member_name')->get();
        $sell_detail = SellDetail::where('sell_id', $sell_id)->orderBy('id')->get();

        return view('sell_detail.index', [
            'title' => 'transaction | sell_detail',
            'product' => $product,
            'member' => $member,
            'sell_id' => $sell_id,
            'sell_detail' => $sell_detail
        ]);
    }

    public function sellDetailAdd(Request $request)
    {
        $sellDetail = new SellDetail();
        $sellDetail->sell_id = $request->sell_id;
        $sellDetail->product_id = $request->product_id;
        $sellDetail->product_code = $request->product_code;
        $sellDetail->product_name = $request->product_name;
        $sellDetail->price = $request->price;
        $sellDetail->quantity = $request->quantity;
        $sellDetail->diskon = $request->diskon;
        $sellDetail->sub_total = $request->sub_total;
        $sellDetail->save();

        $sellDetail->product_code = $request->product_code;

        return response()->json($sellDetail);
    }

    public function sellDetailDelete($id)
    {
        $sellDetail = SellDetail::find($id);
        $sellDetail->delete();

        return response()->json(['success' => 'Data has been deleted!']);
    }

    public function sellDetailUpdate(Request $request)
    {
        $quantity = $request->qty;
        $price = $request->price;
        $sub_total = $quantity * $price;

        $sellDetail = SellDetail::find($request->id);
        $sellDetail->quantity = $quantity;
        $sellDetail->sub_total = $sub_total;
        $sellDetail->save();

        return response()->json($sellDetail);
    }

    public function sellDetailUpdateFinal(Request $request)
    {
        $sell = Sell::find($request->sell_id);
        $sell->total = $request->total_harga;
        $sell->member_name = $request->member_name;
        $sell->diskon = $request->diskon;
        $sell->bayar = $request->total_bayar;
        $sell->diterima = $request->diterima;
        $sell->update();

        // Update Quantity di table products
        $sellDetail = SellDetail::where('sell_id', $request->sell_id)->get();

        foreach($sellDetail as $data){
            $product = Product::find($data['product_id']);
            $product->stock -= $data['quantity'];
            $product->update();
        }

        return response()->json('Transaksi Penjualan Berhasil');
        
    }
}
