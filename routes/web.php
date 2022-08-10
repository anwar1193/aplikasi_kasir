<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BuyDetailController;
use App\Http\Controllers\SellDetailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', function(){
    return view('dashboard.index', [
        'title' => 'Dashboard'
    ]);
})->middleware('auth');

// Category
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'addCategory'])->name('category.add');
Route::get('/category/{id}', [CategoryController::class, 'editCategory']);
Route::put('/category', [CategoryController::class, 'updateCategory'])->name('category.update');
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

// Product
Route::get('/product', [ProductController::class, 'index'])->middleware('auth');
Route::post('/product', [ProductController::class, 'addProduct'])->name('product.add');
Route::get('/product/{id}', [ProductController::class, 'editProduct']);
Route::put('/product', [ProductController::class, 'updateProduct'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);
Route::delete('/product-selected', [ProductController::class, 'deleteSelected'])->name('product.deleteSelected');
Route::post('/product-barcode', [ProductController::class, 'printBarcode'])->name('product.printBarcode');

// Member
Route::get('/member', [MemberController::class, 'index'])->middleware('auth');
Route::post('/member', [MemberController::class, 'addMember'])->name('member.add');
Route::get('/member/{id}', [MemberController::class, 'editMember']);
Route::put('/member', [MemberController::class, 'updateMember'])->name('member.update');
Route::delete('/member/{id}', [MemberController::class, 'deleteMember']);

// Supplier
Route::get('/supplier', [SupplierController::class, 'index'])->middleware('auth');
Route::post('/supplier', [SupplierController::class, 'addSupplier'])->name('supplier.add');
Route::get('/supplier/{id}', [SupplierController::class, 'editSupplier']);
Route::put('/supplier', [SupplierController::class, 'updateSupplier'])->name('supplier.update');
Route::delete('/supplier/{id}', [SupplierController::class, 'deleteSupplier']);

// Pembelian
Route::get('/buy', [BuyController::class, 'index'])->middleware('auth');
Route::get('/buy_create/{id}', [BuyController::class, 'createBuy'])->name('buy.create');

// Pembelian Detail
Route::get('/buy_detail', [BuyDetailController::class, 'index'])->name('buy_detail.index');
Route::post('/buy_detail', [BuyDetailController::class, 'buyDetailAdd'])->name('buyDetail.add');
Route::delete('/buy_detail/{id}', [BuyDetailController::class, 'buyDetailDelete']);
Route::put('/buy_detail', [BuyDetailController::class, 'buyDetailUpdate'])->name('buy_detail.update');
Route::put('/buy_detail_update', [BuyDetailController::class, 'buyDetailUpdateFinal'])->name('buy_detail_final.update');

// Penjualan
Route::get('/sell', [SellController::class, 'create'])->middleware('auth');

// Penjualan Detail
Route::get('/sell_detail', [SellDetailController::class, 'index'])->middleware('auth')->name('sell_detail.index');
Route::post('/sell_detail', [SellDetailController::class, 'sellDetailAdd'])->name('sellDetail.add');
Route::delete('/sell_detail/{id}', [SellDetailController::class, 'sellDetailDelete']);
Route::put('/sell_detail', [SellDetailController::class, 'sellDetailUpdate'])->name('sell_detail.update');
Route::put('/sell_detail_update', [SellDetailController::class, 'sellDetailUpdateFinal'])->name('sell_detail_final.update');