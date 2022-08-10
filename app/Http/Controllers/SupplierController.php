<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {
        $str_random = Str::random(7);
        $no_supplier_otomatis = 'SPL-'.$str_random;
        $suppliers = Supplier::orderBy('id')->get();
        return view('supplier.index', [
            'title' => 'master | supplier',
            'suppliers' => $suppliers,
            'no_supplier_otomatis' => $no_supplier_otomatis
        ]);
    }

    public function addSupplier(Request $request)
    {
        $supplier = new Supplier();
        $supplier->supplier_code = $request->supplier_code;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_address = $request->supplier_address;
        $supplier->supplier_phone = $request->supplier_phone;
        $supplier->save();

        return response()->json($supplier);
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    public function updateSupplier(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->supplier_code = $request->supplier_code;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_address = $request->supplier_address;
        $supplier->supplier_phone = $request->supplier_phone;
        $supplier->save();

        return response()->json($supplier);
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return response()->json(['success' => 'supplier has been deleted']);
    }
}
