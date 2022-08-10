@extends('layouts.main')

@section('mainContent')
    
<div class="content-wrapper pb-0">
    {{-- Header Content --}}
    <div class="page-header flex-wrap">
      <h3 class="mb-0"> Products <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Create, Read, Update, Delete</span>
      </h3>

    </div>
    {{-- END Header Content --}}

    {{-- Body Content --}}
    <div class="row">
      
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card table-responsive">
              <div class="card-body">

                <div class="d-flex">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-add">
                        <i class="mdi mdi-plus-circle"></i> Add New Product
                    </button>

                    <a href="#" class="btn btn-danger btn-sm" id="deleteAllSelectedRecord">
                      <i class="mdi mdi-delete-forever"></i> Delete Selected Product
                    </a>

                    <button onclick="printBarcode('{{ route('product.printBarcode') }}')" class="btn btn-sm btn-info">
                        <i class="mdi mdi-barcode-scan"></i> Print Barcode
                    </button>
                </div>

                {{-- tableDT --}}

                <div class="table-responsive-md mt-3">
                  <form action="" method="post" class="form-product">
                    @csrf
                  <table id="tableDT" class="table table-bordered">

                    <thead class="thead-dark">
                      <tr>
                        <th>No</th>
                        <th>
                          <input type="checkbox" id="select_all">
                        </th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Category</th>
                        <th>Merk</th>
                        <th>Harga Beli</th>
                        <th>Diskon</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($products as $product)
                        <tr id="sid{{ $product['id'] }}">

                            <td class="td_norut">
                              {{ $loop->iteration }}
                              <input type="text" id="nomor_urut" value="{{ $loop->iteration }}" hidden>
                            </td>

                            <td>
                              <input type="checkbox" name="ids[]" id="ids" class="checkBoxClass" value="{{ $product['id'] }}">
                            </td>

                            <td>{{ $product['product_code'] }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['product_category'] }}</td>
                            <td>{{ $product['product_merk'] }}</td>
                            <td>{{ $product['buy_price'] }}</td>
                            <td>{{ $product['discount'] }}</td>
                            <td>{{ $product['sell_price'] }}</td>
                            <td>{{ $product['stock'] }}</td>

                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="editProduct({{ $product['id'] }})" class="btn btn-success btn-xs">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>

                                <a href="javascript:void(0)" onclick="deleteProduct({{ $product['id'] }})" class="btn btn-danger btn-xs">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>

                  </table>
                  </form>

                </div>
              </div>
            </div>
        </div>

    </div>
    {{-- END Body Content --}}

</div>

{{-- Modal Add Data --}}
<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Input Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-add">
            @csrf
            <div class="form-group">
                <label for="product_code">Kode Produk</label>
                <input type="text" class="form-control" id="product_code" value="{{ $product_code_gen }}" readonly>
            </div>

            <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input type="text" class="form-control" id="product_name" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="product_category">Kategori</label>
                <select id="product_category" class="form-control">
                    <option value="">- Pilih Kategori -</option>

                    @foreach ($categories as $row)
                        <option value="{{ $row['category_name'] }}">{{ $row['category_name'] }}</option>
                    @endforeach
                
                </select>
            </div>

            <div class="form-group">
                <label for="product_merk">Merk</label>
                <input type="text" class="form-control" id="product_merk" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="buy_price">Harga Beli</label>
                <input type="number" class="form-control" id="buy_price" autocomplete="off" placeholder="Rp">
            </div>

            <div class="form-group">
                <label for="discount">Diskon</label>
                <input type="number" class="form-control" id="discount" autocomplete="off" placeholder="Dalam %">
            </div>

            <div class="form-group">
                <label for="sell_price">Harga Jual</label>
                <input type="number" class="form-control" id="sell_price" autocomplete="off" placeholder="Rp">
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" class="form-control" id="stock" autocomplete="off" placeholder="">
            </div>

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Data</button>
          </form>
        </div>

      </div>
    </div>
</div>
{{-- END Modal Add Data --}}


{{-- Modal Edit Data --}}
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit">
          @csrf
            <input type="text" id="id" name="id" hidden>
          
            <div class="form-group">
                <label for="product_code2">Kode Produk</label>
                <input type="text" class="form-control" id="product_code2" readonly>
            </div>

            <div class="form-group">
                <label for="product_name2">Nama Produk</label>
                <input type="text" class="form-control" id="product_name2" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="product_category2">Kategori</label>
                <select id="product_category2" class="form-control">
                    <option value="">- Pilih Kategori -</option>

                    @foreach ($categories as $row)
                        <option value="{{ $row['category_name'] }}">{{ $row['category_name'] }}</option>
                    @endforeach
                
                </select>
            </div>

            <div class="form-group">
                <label for="product_merk2">Merk</label>
                <input type="text" class="form-control" id="product_merk2" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="buy_price2">Harga Beli</label>
                <input type="number" class="form-control" id="buy_price2" autocomplete="off" placeholder="Rp">
            </div>

            <div class="form-group">
                <label for="discount2">Diskon</label>
                <input type="number" class="form-control" id="discount2" autocomplete="off" placeholder="Dalam %">
            </div>

            <div class="form-group">
                <label for="sell_price2">Harga Jual</label>
                <input type="number" class="form-control" id="sell_price2" autocomplete="off" placeholder="Rp">
            </div>

            <div class="form-group">
                <label for="stock2">Stok</label>
                <input type="number" class="form-control" id="stock2" autocomplete="off" placeholder="">
            </div>

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
      </div>

    </div>
  </div>
</div>
{{-- END Modal Edit Data --}}

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $('#form-add').submit(function(e){
        e.preventDefault();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        let product_code = $('#product_code').val();
        let product_name = $('#product_name').val();
        let product_category = $('#product_category').val();
        let product_merk = $('#product_merk').val();
        let buy_price = $('#buy_price').val();
        let discount = $('#discount').val();
        let sell_price = $('#sell_price').val();
        let stock = $('#stock').val();

        let nomor_urut0 = $('.td_norut:last #nomor_urut').val();
        let nomor_urut = Number(nomor_urut0);
        nomor_urut++;

        // Validasi tidak boleh kosong
        if(product_name == ''){$('#product_name').addClass("is-invalid");return false;}
        if(product_category == ''){$('#product_category').addClass("is-invalid");return false;}
        if(product_merk == ''){$('#product_merk').addClass("is-invalid");return false;}
        if(buy_price == ''){$('#buy_price').addClass("is-invalid");return false;}
        if(discount == ''){$('#discount').addClass("is-invalid");return false;}
        if(sell_price == ''){$('#sell_price').addClass("is-invalid");return false;}
        if(stock == ''){$('#stock').addClass("is-invalid");return false;}
        
        $.ajax({
          url:"{{ route('product.add') }}",
          type:"POST",
          data:{
            product_code:product_code,
            product_name:product_name,
            product_category:product_category,
            product_merk:product_merk,
            buy_price:buy_price,
            discount:discount,
            sell_price:sell_price,
            stock:stock
          },
          success:function(response){
            if(response){

              alert("New Product Added!");
              
              $('#tableDT').append(`
                <tr>
                  <td class="td_norut">
                    ${nomor_urut}
                    <input type="text" id="nomor_urut" value="${nomor_urut}" hidden>
                  </td>  

                  <td>
                    <input type="checkbox" name="ids" class="checkBoxClass" value="${response.id}">
                  </td>
                  
                  <td>${response.product_code}</td>
                  <td>${response.product_name}</td>
                  <td>${response.product_category}</td>
                  <td>${response.product_merk}</td>
                  <td>${response.buy_price}</td>
                  <td>${response.discount}</td>
                  <td>${response.sell_price}</td>
                  <td>${response.stock}</td>

                  <td class="text-center">
                      <a href="javascript:void(0)" onclick="editProduct(${response.id})" class="btn btn-success btn-xs">
                          <i class="mdi mdi-table-edit"></i>
                      </a>

                      <a href="javascript:void(0)" onclick="deleteProduct(${response.id})" class="btn btn-danger btn-xs">
                          <i class="mdi mdi-delete"></i>
                      </a>
                  </td>
                </tr>
              `);

              $('#form-add')[0].reset();
              $('#modal-add').modal('hide');
            }
          }
        });
    });
</script>

<script>
  function editCategory(id)
  {
    $.get('/category/' + id, function(category){
      $('#id').val(category.id);
      $('#category_name2').val(category.category_name);
      $('#modal-edit').modal('toggle');
    });
  }

  $('#form-edit').submit(function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let id = $('#id').val();
    let category_name = $('#category_name2').val();

    if(category_name == ''){
      $('#category_name2').addClass('is-invalid');
      return false;
    }

    $.ajax({
      url:"{{ route('category.update') }}",
      type:"PUT",
      data:{
        id:id,
        category_name:category_name
      },
      success:function(response){
        alert("Category Updated!");
        $('#sid' + response.id + ' td:nth-child(2)').text(response.category_name);
        $('#modal-edit').modal('toggle');
        $('#form-edit')[0].reset();
      }
    });

  });

</script>


<script>
  function deleteCategory(id)
  {
    if(confirm("Do you want to delete this record?"))
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url:'/category/'+id,
        type:'DELETE',
        data:{},
        success:function(response){
          alert("Category has been deleted!");
          $('#sid'+id).remove();
        }
      });
    }
  }
</script>


<script>
    function editProduct(id)
    {
        $.get('/product/'+id, function(product){
            $('#id').val(product.id);
            $('#product_code2').val(product.product_code);
            $('#product_name2').val(product.product_name);
            $('#product_category2').val(product.product_category);
            $('#product_merk2').val(product.product_merk);
            $('#buy_price2').val(product.buy_price);
            $('#discount2').val(product.discount);
            $('#sell_price2').val(product.sell_price);
            $('#stock2').val(product.stock);
            $('#modal-edit').modal('toggle');
        });
    }

    $('#form-edit').submit(function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let id = $('#id').val();
        let product_code = $('#product_code2').val();
        let product_name = $('#product_name2').val();
        let product_category = $('#product_category2').val();
        let product_merk = $('#product_merk2').val();
        let buy_price = $('#buy_price2').val();
        let discount = $('#discount2').val();
        let sell_price = $('#sell_price2').val();
        let stock = $('#stock2').val();

        $.ajax({
            url:"{{ route('product.update') }}",
            type:"PUT",
            data:{
                id:id,
                product_code:product_code,
                product_name:product_name,
                product_category:product_category,
                product_merk:product_merk,
                buy_price:buy_price,
                discount:discount,
                sell_price:sell_price,
                stock:stock
            },
            success:function(response){
                alert("Product Update!");
                $('#sid'+response.id + ' td:nth-child(3)').text(response.product_code);
                $('#sid'+response.id + ' td:nth-child(4)').text(response.product_name);
                $('#sid'+response.id + ' td:nth-child(5)').text(response.product_category);
                $('#sid'+response.id + ' td:nth-child(6)').text(response.product_merk);
                $('#sid'+response.id + ' td:nth-child(7)').text(response.buy_price);
                $('#sid'+response.id + ' td:nth-child(8)').text(response.discount);
                $('#sid'+response.id + ' td:nth-child(9)').text(response.sell_price);
                $('#sid'+response.id + ' td:nth-child(10)').text(response.stock);
                $('#modal-edit').modal('toggle');
                $('#form-edit')[0].reset();
            }
        });

    });
</script>


<script>
    function deleteProduct(id)
    {
        if(confirm("Do you want to delete this record?")){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"/product/"+id,
                type:'DELETE',
                data:{},
                success:function(response){
                    alert("Product has been deleted");
                    $('#sid'+id).remove();
                }
            });
        }
    }
</script>


{{-- Script Delete Checkbox --}}
<script>

  $(function(e){

    $('#select_all').click(function(){
      $('.checkBoxClass').prop('checked', $(this).prop('checked'));
    });

    $('#deleteAllSelectedRecord').click(function(e){
      e.preventDefault();
      let allIds = [];

      $('#ids:checked').each(function(){
        allIds.push($(this).val());
      });

      // Validasi harus ada yang di checklist
      if(allIds.length < 1){
        alert("Pilih data yang ingin dihapus!");
        return false;
      }

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url:"{{ route('product.deleteSelected') }}",
        type:"DELETE",
        data:{
          ids:allIds
        },
        success:function(response){
          alert("Product has been deleted!");
          $.each(allIds, function(key, val){
            $('#sid' + val).remove();
          });
        }
      });

    });
  });

</script>


{{-- Script Print Barcode --}}
<script>
  function printBarcode(url)
  {
    if($('input:checked').length < 1){

      alert('Pilih data yang akan di cetak');
      return false;

    }else if($('input:checked').length < 3){

      alert("Pilih minimal 3 data untuk di cetak");
      return false;

    }else{
      $('.form-product')
        .attr('target', '_blank')
        .attr('action', url)
        .submit();
    }
  }
</script>

  @endsection