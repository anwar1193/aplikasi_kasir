<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id')->get();
        $categories = Category::orderBy('category_name')->get();

        $random_string = Str::random(7);
        $product_code_gen = date('Y-m-d').'-'.$random_string;

        return view('product.index', [
            'title' => 'master | product',
            'products' => $products,
            'categories' => $categories,
            'product_code_gen' => $product_code_gen
        ]);
    }


    public function addProduct(Request $request)
    {
        $product = new Product();
        $product->product_code = $request->product_code;
        $product->product_name = $request->product_name;
        $product->product_category = $request->product_category;
        $product->product_merk = $request->product_merk;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->save();

        return response()->json($product);
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function updateProduct(Request $request)
    {
        $product = Product::find($request->id);
        $product->product_code = $request->product_code;
        $product->product_name = $request->product_name;
        $product->product_category = $request->product_category;
        $product->product_merk = $request->product_merk;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->save();

        return response()->json($product);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['success' => 'Deleted']);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;

        // whereIn menggantikan looping
        Product::whereIn('id', $ids)->delete();
        return response()->json(['success' => 'Student has been deleted!']);
    }

    public function printBarcode(Request $request)
    {
        $dataproduct = array();
        foreach($request->ids as $id){
            $product = Product::find($id);
            $dataproduct[] = $product;
        }

        $no = 1;
        $pdf = PDF::loadView('product.barcode', compact('dataproduct', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('product.pdf');
    }
}
