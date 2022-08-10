<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buy;
use App\Models\Supplier;

class BuyController extends Controller
{
    public function index()
    {
        $buys = Buy::orderBy('id')->get();

        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('buy.index', [
            'title' => 'transaction | buy',
            'buys' => $buys,
            'suppliers' => $suppliers
        ]);
    }

    public function createBuy($id)
    {
        $buy = new Buy();
        $buy->supplier_id = $id;
        $buy->total_harga = 0;
        $buy->diskon = 0;
        $buy->total_bayar = 0;
        $buy->save();

        session(['buy_id' => $buy->id]);
        session(['supplier_id' => $buy->supplier_id]);

        return redirect()->route('buy_detail.index');
    }
}
