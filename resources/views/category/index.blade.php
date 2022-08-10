@extends('layouts.main')

@section('mainContent')
    
<div class="content-wrapper pb-0">
    {{-- Header Content --}}
    <div class="page-header flex-wrap">
      <h3 class="mb-0"> Categories <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Create, Read, Update, Delete</span>
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
                        <i class="mdi mdi-plus-circle"></i> Add New Category
                    </button>
                </div>

                <div class="table-responsive mt-3">
                  <table id="tableDT" class="table table-bordered">

                    <thead class="thead-dark">
                      <tr>
                        <th>No</th>
                        <th>Category Name</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($categories as $category)
                        <tr id="sid{{ $category['id'] }}">
                            <td class="td_norut">
                              {{ $loop->iteration }}
                              <input type="text" id="nomor_urut" value="{{ $loop->iteration }}" hidden>
                            </td>
                            <td>{{ $category['category_name'] }}</td>

                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="editCategory({{ $category['id'] }})" class="btn btn-success btn-xs">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>

                                <a href="javascript:void(0)" onclick="deleteCategory({{ $category['id'] }})" class="btn btn-danger btn-xs">
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
          <h5 class="modal-title" id="exampleModalLabel">Input Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-add">
            @csrf
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" autocomplete="off">
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
        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit">
          @csrf
          <input type="text" id="id" name="id" hidden>
          <div class="form-group">
              <label for="category_name">Category Name</label>
              <input type="text" class="form-control" id="category_name2" autocomplete="off">
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

        let category_name = $('#category_name').val();
        let nomor_urut0 = $('.td_norut:last #nomor_urut').val();
        let nomor_urut = Number(nomor_urut0);
        nomor_urut++;

        // Validasi tidak boleh kosong
        if(category_name == ''){
          $('#category_name').addClass("is-invalid");
          return false;
        }
        
        $.ajax({
          url:"{{ route('category.add') }}",
          type:"POST",
          data:{
            category_name:category_name
          },
          success:function(response){
            if(response){

              alert("New Category Added!");
              
              $('#tableDT').append(`
                <tr>
                  <td class="td_norut">
                    ${nomor_urut}
                    <input type="text" id="nomor_urut" value="${nomor_urut}" hidden>
                  </td>  
                  
                  <td>${response.category_name}</td>

                  <td class="text-center">
                      <a href="javascript:void(0)" onclick="editCategory(${response.id})" class="btn btn-success btn-xs">
                          <i class="mdi mdi-table-edit"></i>
                      </a>

                      <a href="javascript:void(0)" onclick="deleteCategory(${response.id})" class="btn btn-danger btn-xs">
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
  $('#category_name').on('keyup', function(){
    $('#category_name').removeClass('is-invalid').addClass('is-valid');
  });
</script>

  @endsection