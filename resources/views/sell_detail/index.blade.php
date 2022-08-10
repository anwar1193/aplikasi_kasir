@extends('layouts.main')

@section('mainContent')
    
<div class="content-wrapper pb-0">
    {{-- Header Content --}}
    <div class="page-header flex-wrap">
      <h3 class="mb-0"> Transaksi Penjualan <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Add New Transaction (Sess-id-{{ $sell_id }})</span>
      </h3>

    </div>
    {{-- END Header Content --}}

    {{-- Body Content --}}
    <div class="row">
      
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

                {{-- Cari Product --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">

                                <input type="text" name="sell_id" id="sell_id" value="{{ $sell_id }}" hidden>
                                <input type="text" name="product_id" id="product_id" hidden>
                                <input type="text" class="form-control" placeholder="Tambahkan Produk (Klik Tanda Plus Disamping) atau Scan Barcode" name="product_code" id="product_code" value=""/>

                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal-product"> <i class="mdi mdi-plus-box"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table Sell Detail / Products --}}
                <div class="table-responsive mt-3">
                  <table id="tableSellDetail" class="table table-bordered">

                    <tr style="background-color: #e3e1e1">
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                        <th class="text-center">Action</th>
                    </tr>

                    @foreach ($sell_detail as $data)
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
                                <a href="javascript:void(0)" onclick="deleteSellDetail({{ $data['id'] }})" class="btn btn-danger btn-xs">
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

                        <div class="bg-info text-center text-white mt-2" style="padding: 10px">
                            <span id="uang_kembali_v" style="font-size: 50px">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    {{-- Bayar --}}
                    <div class="col-md-4">
                        <table class="table">
                            <tr>
                                <th>Total Belanja</th>
                                <th>:</th>
                                <th><input type="text" class="form-control" id="total" readonly></th>
                            </tr>

                            <tr>
                                <th>Member</th>
                                <th>:</th>
                                <th>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pilih Member/Scan MemberCard" name="member_name" id="member_name" value=""/>

                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#modal-member"> <i class="mdi mdi-account-search"></i> </button>
                                        </div>
                                    </div>
                                </th>
                            </tr>

                            <tr>
                                <th>Diskon (%)</th>
                                <th>:</th>
                                <th><input type="number" class="form-control" id="diskon" value="0"></th>
                            </tr>

                            <tr>
                                <th>Bayar</th>
                                <th>:</th>
                                <th><input type="text" class="form-control" id="grandTotal" value="0" readonly></th>
                            </tr>

                            <tr>
                                <th>Diterima</th>
                                <th>:</th>
                                <th><input type="number" class="form-control" id="diterima" value="0"></th>
                            </tr>

                            <tr>
                                <th>Kembali</th>
                                <th>:</th>
                                <th><input type="number" class="form-control" id="uang_kembali" value="0" readonly></th>
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
                    <th>Sell Price</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($product as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['product_code'] }}</td>
                        <td>{{ $data['product_name'] }}</td>
                        <td>{{ 'Rp '.number_format($data['sell_price'], 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary" id="pilihProduct"
                                data-product_id = "{{ $data['id'] }}"
                                data-product_code = "{{ $data['product_code'] }}"
                                data-product_name = "{{ $data['product_name'] }}"
                                data-sell_price = "{{ $data['sell_price'] }}"
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


{{-- Modal Member Data --}}
<div class="modal fade" id="modal-member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body table-responsive">
          <table id="tableDT2" class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Member Code</th>
                    <th>Member Name</th>
                    <th>Member Address</th>
                    <th>Member Phone</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($member as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['member_code'] }}</td>
                        <td>{{ $data['member_name'] }}</td>
                        <td>{{ $data['member_address'] }}</td>
                        <td>{{ $data['member_phone'] }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary" id="pilihMember"
                                data-member_id = "{{ $data['id'] }}"
                                data-member_code = "{{ $data['member_code'] }}"
                                data-member_name = "{{ $data['member_name'] }}"
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
{{-- END Modal Member Data --}}

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

        $('#tableSellDetail tr').each(function(){
          total += Number($(this).find('#sub_total_row').text());
        });

        let diskon_total = total * (diskon / 100);

        let grandTotal = total - diskon_total;

        let diterima = Number($('#diterima').val());

        let uang_kembali = diterima - grandTotal;

        $('#total').val(total);

        $('#grandTotal_v').text(`Tot.Belanja : Rp ${rubah(grandTotal)}`);
        $('#grandTotal').val(grandTotal);

        $('#uang_kembali').val(uang_kembali);

        if(uang_kembali < 0){
            $('#uang_kembali_v').text(`Kembali : Rp -${rubah(uang_kembali)}`);
        }else{
            $('#uang_kembali_v').text(`Kembali : Rp ${rubah(uang_kembali)}`);
        }
        

      }

    hitung_total();
    
    // Add Sell Detail...........................................
    $(document).on('click', '#pilihProduct', function(){
        let product_id = $(this).data('product_id');
        let sell_id = $('#sell_id').val();
        let product_code = $(this).data('product_code');
        let product_name = $(this).data('product_name');
        let sell_price = $(this).data('sell_price');
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            url:"{{ route('sellDetail.add') }}",
            type:"POST",
            data:{
                sell_id:sell_id,
                product_id:product_id,
                product_code:product_code,
                product_name:product_name,
                price:sell_price,
                quantity:1,
                diskon:0,
                sub_total:sell_price
            },
            success:function(response){
                if(response){
                    $('#tableSellDetail').append(`
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
                                <a href="javascript:void(0)" onclick="deleteSellDetail(${response.id})" class="btn btn-danger btn-xs">
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


    // Delete Sell Detail........................................
    function deleteSellDetail(id)
    {
        if(confirm("Do you want to delete this record?"))
        {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/sell_detail/'+id,
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
            url:"{{ route('sell_detail.update') }}",
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
        let sell_id = $('#sell_id').val();
        let total_harga = $('#total').val();
        let member_name = $('#member_name').val();
        let diskon = $('#diskon').val();
        let total_bayar = $('#grandTotal').val();
        let diterima = $('#diterima').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"{{ route('sell_detail_final.update') }}",
            type:"PUT",
            data:{
                sell_id:sell_id,
                total_harga:total_harga,
                member_name:member_name,
                diskon:diskon,
                total_bayar:total_bayar,
                diterima:diterima
            },
            success:function(response){
                if(response){
                    alert(response);window.location="../product";
                }
            }
        });
    });


    // Saat pilih member
    $(document).on('click', '#pilihMember', function(){
        let member_name = $(this).data('member_name');
        let member_code = $(this).data('member_code');

        if($('#member_name').val(member_name)){
            let diskon_presentase = 10;
            $('#diskon').val(diskon_presentase);
            hitung_total();
        }
        $('#modal-member').modal('hide');
    });


    // Saat inputan diterima diisi
    $(document).on('keyup', '#diterima', function(){
        hitung_total();
    });


</script>


  @endsection