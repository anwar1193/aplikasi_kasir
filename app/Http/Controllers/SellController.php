<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sell;

class SellController extends Controller
{
    public function create()
    {
        $sell = new Sell();
        $sell->total = 0;
        $sell->member_name = '';
        $sell->diskon = 0;
        $sell->bayar = 0;
        $sell->diterima = 0;
        $sell->save();

        session(['sell_id' => $sell->id]);
        return redirect()->route('sell_detail.index');
    }
}
