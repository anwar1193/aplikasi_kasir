@extends('layouts.main')

@section('mainContent')
    
<div class="content-wrapper pb-0">
    {{-- Header Content --}}
    <div class="page-header flex-wrap">
      <h3 class="mb-0"> Detail Pembelian <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Add Product Detail (Sess-id-{{ $buy_id }})</span>
      </h3>

    </div>
    {{-- END Header Content --}}

    {{-- Body Content --}}
    <div class="row">
      
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

                {{-- Data Nama Supplier, ALamat Supplier, Nomor Telepon Supplier --}}
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th>Nama Supplier</th>
                                <th>:</th>
                                <td>{{ $supplier['supplier_name'] }}</td>
                            </tr>
        
                            <tr>
                                <th>Alamat</th>
                                <th>:</th>
                                <td>{{ $supplier['supplier_address'] }}</td>
                            </tr>
        
                            <tr>
                                <th>Nomor Telepon</th>
                                <th>:</th>
                                <td>{{ $supplier['supplier_phone'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                {{-- Cari Product --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">

                                <input type="text" name="buy_id" id="buy_id" value="{{ $buy_id }}" hidden>
                                <input type="text" name="product_id" id="product_id" hidden>
                                <input type="text" class="form-control" placeholder="Tambahkan Produk (Klik Tanda Plus Disamping)" name="product_code" id="product_code" value=""/>

                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal-product"> <i class="mdi mdi-plus-box"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table Buy Detail / Products --}}
                <div class="table-responsive mt-3">
                  <table id="tableBuyDetail" class="table table-bordered">

                    <tr style="background-color: #e3e1e1">
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                        <th class="text-center">Action</th>
                    </tr>

                    @foreach ($buy_detail as $data)
                        <tr id="sid{{ $data['id'] }}">
                            <td>{{ $data->product->product_code }}</td>
                            <td>{{ $data['product_name'] }}</td>
                            <td>{{ $data['price'] }}</td>
                            <td style="padding-right: 20px" width="10%">
                                <input type="number" value="{{ $data['quantity'] }}" class="form-control" id="qty" 
                                data-id="{{ $data['id'] }}"
                                data-price="{{ $data['price'] }}"
                                >
                            </td>
                            <td id="sub_total_row">{{ $data['sub_total'] }}</td>
                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="deleteBuyDetail({{ $data['id'] }})" class="btn btn-danger btn-xs">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                  </table>

                </div>

                {{-- Total & Bayar --}}
                <div class="row mt-3">
                    {{-- Total --}}
                    <div class="col-md-8">
                        <div class="bg-primary text-center text-white" style="padding: 10px">
                            <span id="grandTotal_v" style="font-size: 50px">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    {{-- Bayar --}}
                    <div class="col-md-4">
                        <table class="table">
                            <tr>
                                <th>Total</th>
                                <th>:</th>
                                <th><input type="text" class="form-control" id="total" readonly></th>
                            </tr>

                            <tr>
                                <th>Diskon (Rp)</th>
                                <th>:</th>
                                <th><input type="number" class="form-control" id="diskon" value="0"></th>
                            </tr>

                            <tr>
                                <th>Bayar</th>
                                <th>:</th>
                                <th><input type="text" class="form-control" id="grandTotal" value="0" readonly></th>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-right">
                                    <button class="btn btn-success" id="simpan_transaksi">
                                        <i class=""></i> Simpan Transaksi
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- END Total & Bayar --}}
              </div>
            </div>
        </div>

    </div>
    {{-- END Body Content --}}

</div>

{{-- Modal Product Data --}}
<div class="modal fade" id="modal-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body table-responsive">
          <table id="tableDT" class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Buy Price</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($product as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['product_code'] }}</td>
                        <td>{{ $data['product_name'] }}</td>
                        <td>{{ 'Rp '.number_format($data['buy_price'], 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary" id="pilihProduct"
                                data-product_id = "{{ $data['id'] }}"
                                data-product_code = "{{ $data['product_code'] }}"
                                data-product_name = "{{ $data['product_name'] }}"
                                data-buy_price = "{{ $data['buy_price'] }}"
                            >
                                <i class="mdi mdi-check-circle"></i> Pilih
                            </a>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
          </table>
        </div>

      </div>
    </div>
</div>
{{-- END Modal Product Data --}}

<meta name="csrf-token" content="{{ csrf_token() }}">


<script>

    // Rubah format angka javascript
    function rubah(angka){
         let reverse = angka.toString().split('').reverse().join(''),
         ribuan = reverse.match(/\d{1,3}/g);
         ribuan = ribuan.join(',').split('').reverse().join('');
         return ribuan;
    }

    // Hitung Totalan
    function hitung_total(){
        let total = 0;
        let diskon = Number($('#diskon').val());

        $('#tableBuyDetail tr').each(function(){
          total += Number($(this).find('#sub_total_row').text());
        });

        let grandTotal = total - diskon;

        $('#total').val(total);
        $('#grandTotal_v').text(`Bayar : Rp ${rubah(grandTotal)}`);
        $('#grandTotal').val(grandTotal);

      }

    hitung_total();
    
    // Add Buy Detail...........................................
    $(document).on('click', '#pilihProduct', function(){
        let product_id = $(this).data('product_id');
        let buy_id = $('#buy_id').val();
        let product_code = $(this).data('product_code');
        let product_name = $(this).data('product_name');
        let buy_price = $(this).data('buy_price');
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            url:"{{ route('buyDetail.add') }}",
            type:"POST",
            data:{
                buy_id:buy_id,
                product_id:product_id,
                product_code:product_code,
                product_name:product_name,
                price:buy_price,
                quantity:1,
                sub_total:buy_price
            },
            success:function(response){
                if(response){
                    $('#tableBuyDetail').append(`
                        <tr id="sid${response.id}">
                            <td>${response.product_code}</td>
                            <td>${response.product_name}</td>
                            <td>${response.price}</td>
                            <td style="padding-right: 20px" width="10%">
                                <input type="number" value="${response.quantity}" class="form-control" id="qty" 
                                data-id="${response.id}"
                                data-price="${response.price}"
                                >
                            </td>
                            <td id="sub_total_row">${response.sub_total}</td>
                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="deleteBuyDetail(${response.id})" class="btn btn-danger btn-xs">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                        </tr>
                    `);
                    $('#modal-product').modal('hide');
                    hitung_total();
                }
            }
        });
    });


    // Delete Buy Detail........................................
    function deleteBuyDetail(id)
    {
        if(confirm("Do you want to delete this record?"))
        {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/buy_detail/'+id,
            type:'DELETE',
            data:{},
            success:function(response){
                $('#sid'+id).remove();
                hitung_total();
            }
        });
        }
    }


    // Update Quantity...........................................
    $(document).on('mouseleave blur', '#qty', function(){
        let id = $(this).data('id');
        let qty = $(this).val();
        let price = $(this).data('price');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"{{ route('buy_detail.update') }}",
            type:"PUT",
            data:{
                id:id,
                qty:qty,
                price:price
            },
            success:function(response){
                // alert("Quantity Updated!");
                $('#sid' + response.id + ' td:nth-child(5)').text(response.sub_total);
                hitung_total();
            }
        });

    });

    // Diskon di ketik
    $(document).on('keyup', '#diskon', function(){
        hitung_total();
    });


    // Tombol Simpan Transaksi Di Klik
    $(document).on('click', '#simpan_transaksi', function(){
        let buy_id = $('#buy_id').val();
        let total_harga = $('#total').val();
        let diskon = $('#diskon').val();
        let total_bayar = $('#grandTotal').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"{{ route('buy_detail_final.update') }}",
            type:"PUT",
            data:{
                buy_id:buy_id,
                total_harga:total_harga,
                diskon:diskon,
                total_bayar:total_bayar
            },
            success:function(response){
                if(response){
                    alert(response);window.location="../buy";
                }
            }
        });
    });


</script>


  @endsection