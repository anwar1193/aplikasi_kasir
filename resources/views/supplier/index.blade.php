@extends('layouts.main')

@section('mainContent')
    
<div class="content-wrapper pb-0">
    {{-- Header Content --}}
    <div class="page-header flex-wrap">
      <h3 class="mb-0"> Suppliers <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Create, Read, Update, Delete</span>
      </h3>

    </div>
    {{-- END Header Content --}}

    {{-- Body Content --}}
    <div class="row">
      
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

                <div class="d-flex">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-add">
                        <i class="mdi mdi-plus-circle"></i> Add New Suppliers
                    </button>
                </div>

                <div class="table-responsive mt-3">
                  <table id="tableDT" class="table table-bordered">

                    <thead class="thead-dark">
                      <tr>
                        <th>No</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Supplier Address</th>
                        <th>Supplier Phone</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($suppliers as $supplier)
                        <tr id="sid{{ $supplier['id'] }}">
                            <td class="td_norut">
                              {{ $loop->iteration }}
                              <input type="text" id="nomor_urut" value="{{ $loop->iteration }}" hidden>
                            </td>
                            <td>{{ $supplier['supplier_code'] }}</td>
                            <td>{{ $supplier['supplier_name'] }}</td>
                            <td>{{ $supplier['supplier_address'] }}</td>
                            <td>{{ $supplier['supplier_phone'] }}</td>

                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="editSupplier({{ $supplier['id'] }})" class="btn btn-success btn-xs">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>

                                <a href="javascript:void(0)" onclick="deleteSupplier({{ $supplier['id'] }})" class="btn btn-danger btn-xs">
                                    <i class="mdi mdi-delete"></i>
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

    </div>
    {{-- END Body Content --}}

</div>

{{-- Modal Add Data --}}
<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Input Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-add">
            @csrf
            <div class="form-group">
                <label for="supplier_code">Supplier Code</label>
                <input type="text" class="form-control" id="supplier_code" autocomplete="off" value="{{ $no_supplier_otomatis }}" readonly>
            </div>

            <div class="form-group">
                <label for="supplier_name">Supplier Name</label>
                <input type="text" class="form-control" id="supplier_name" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="supplier_address">Supplier Address</label>
                <textarea name="supplier_address" id="supplier_address" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="supplier_phone">Supplier Phone</label>
                <input type="number" class="form-control" id="supplier_phone" autocomplete="off">
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
        <h5 class="modal-title" id="exampleModalLabel">Update supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit">
          @csrf
          <input type="text" id="id" name="id" hidden>
          <div class="form-group">
              <label for="supplier_code">Supplier Code</label>
              <input type="text" class="form-control" id="supplier_code2" autocomplete="off" readonly>
          </div>

          <div class="form-group">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" class="form-control" id="supplier_name2" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="supplier_address">Supplier Address</label>
            <textarea name="supplier_address" id="supplier_address2" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <label for="supplier_phone">Supplier Phone</label>
            <input type="number" class="form-control" id="supplier_phone2" autocomplete="off">
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

        let supplier_code = $('#supplier_code').val();
        let supplier_name = $('#supplier_name').val();
        let supplier_address = $('#supplier_address').val();
        let supplier_phone = $('#supplier_phone').val();
        let nomor_urut0 = $('.td_norut:last #nomor_urut').val();
        let nomor_urut = Number(nomor_urut0);
        nomor_urut++;

        // Validasi tidak boleh kosong
        if(supplier_name == ''){
          $('#supplier_name').addClass("is-invalid");
          return false;
        }

        if(supplier_address == ''){
          $('#supplier_address').addClass("is-invalid");
          return false;
        }

        if(supplier_phone == ''){
          $('#supplier_phone').addClass("is-invalid");
          return false;
        }
        
        $.ajax({
          url:"{{ route('supplier.add') }}",
          type:"POST",
          data:{
            supplier_code:supplier_code,
            supplier_name:supplier_name,
            supplier_address:supplier_address,
            supplier_phone:supplier_phone
          },
          success:function(response){
            if(response){

              alert("New Supplier Added!");
              
              $('#tableDT').append(`
                <tr>
                  <td class="td_norut">
                    ${nomor_urut}
                    <input type="text" id="nomor_urut" value="${nomor_urut}" hidden>
                  </td>  
                  
                  <td>${response.supplier_code}</td>
                  <td>${response.supplier_name}</td>
                  <td>${response.supplier_address}</td>
                  <td>${response.supplier_phone}</td>

                  <td class="text-center">
                      <a href="javascript:void(0)" onclick="editSupplier(${response.id})" class="btn btn-success btn-xs">
                          <i class="mdi mdi-table-edit"></i>
                      </a>

                      <a href="javascript:void(0)" onclick="deleteSupplier(${response.id})" class="btn btn-danger btn-xs">
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
  function editSupplier(id)
  {
    $.get('/supplier/' + id, function(supplier){
      $('#id').val(supplier.id);
      $('#supplier_code2').val(supplier.supplier_code);
      $('#supplier_name2').val(supplier.supplier_name);
      $('#supplier_address2').val(supplier.supplier_address);
      $('#supplier_phone2').val(supplier.supplier_phone);
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
    let supplier_code = $('#supplier_code2').val();
    let supplier_name = $('#supplier_name2').val();
    let supplier_address = $('#supplier_address2').val();
    let supplier_phone = $('#supplier_phone2').val();

    if(supplier_name == ''){
      $('#supplier_name2').addClass('is-invalid');
      return false;
    }

    if(supplier_address == ''){
      $('#supplier_address2').addClass('is-invalid');
      return false;
    }

    if(supplier_phone == ''){
      $('#supplier_phone2').addClass('is-invalid');
      return false;
    }

    $.ajax({
      url:"{{ route('supplier.update') }}",
      type:"PUT",
      data:{
        id:id,
        supplier_code:supplier_code,
        supplier_name:supplier_name,
        supplier_address:supplier_address,
        supplier_phone:supplier_phone
      },
      success:function(response){
        alert("Supplier Updated!");
        $('#sid' + response.id + ' td:nth-child(2)').text(response.supplier_code);
        $('#sid' + response.id + ' td:nth-child(3)').text(response.supplier_name);
        $('#sid' + response.id + ' td:nth-child(4)').text(response.supplier_address);
        $('#sid' + response.id + ' td:nth-child(5)').text(response.supplier_phone);
        $('#modal-edit').modal('toggle');
        $('#form-edit')[0].reset();
      }
    });

  });

</script>


<script>
  function deleteSupplier(id)
  {
    if(confirm("Do you want to delete this record?"))
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url:'/supplier/'+id,
        type:'DELETE',
        data:{},
        success:function(response){
          alert("Supplier has been deleted!");
          $('#sid'+id).remove();
        }
      });
    }
  }
</script>

  @endsection