@extends('layouts.main')

@section('mainContent')
    
<div class="content-wrapper pb-0">
    {{-- Header Content --}}
    <div class="page-header flex-wrap">
      <h3 class="mb-0"> Members <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Create, Read, Update, Delete</span>
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
                        <i class="mdi mdi-plus-circle"></i> Add New Members
                    </button>
                </div>

                <div class="table-responsive mt-3">
                  <table id="tableDT" class="table table-bordered">

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
                      @foreach ($members as $member)
                        <tr id="sid{{ $member['id'] }}">
                            <td class="td_norut">
                              {{ $loop->iteration }}
                              <input type="text" id="nomor_urut" value="{{ $loop->iteration }}" hidden>
                            </td>
                            <td>{{ $member['member_code'] }}</td>
                            <td>{{ $member['member_name'] }}</td>
                            <td>{{ $member['member_address'] }}</td>
                            <td>{{ $member['member_phone'] }}</td>

                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="editMember({{ $member['id'] }})" class="btn btn-success btn-xs">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>

                                <a href="javascript:void(0)" onclick="deleteMember({{ $member['id'] }})" class="btn btn-danger btn-xs">
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
          <h5 class="modal-title" id="exampleModalLabel">Input Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-add">
            @csrf
            <div class="form-group">
                <label for="member_code">Member Code</label>
                <input type="text" class="form-control" id="member_code" autocomplete="off" value="{{ $no_member_otomatis }}" readonly>
            </div>

            <div class="form-group">
                <label for="member_name">Member Name</label>
                <input type="text" class="form-control" id="member_name" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="member_address">Member Address</label>
                <textarea name="member_address" id="member_address" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="member_phone">Member Phone</label>
                <input type="number" class="form-control" id="member_phone" autocomplete="off">
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
        <h5 class="modal-title" id="exampleModalLabel">Update Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit">
          @csrf
          <input type="text" id="id" name="id" hidden>
          <div class="form-group">
              <label for="member_code">Member Code</label>
              <input type="text" class="form-control" id="member_code2" autocomplete="off" readonly>
          </div>

          <div class="form-group">
            <label for="member_name">Member Name</label>
            <input type="text" class="form-control" id="member_name2" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="member_address">Member Address</label>
            <textarea name="member_address" id="member_address2" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <label for="member_phone">Member Phone</label>
            <input type="number" class="form-control" id="member_phone2" autocomplete="off">
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

        let member_code = $('#member_code').val();
        let member_name = $('#member_name').val();
        let member_address = $('#member_address').val();
        let member_phone = $('#member_phone').val();
        let nomor_urut0 = $('.td_norut:last #nomor_urut').val();
        let nomor_urut = Number(nomor_urut0);
        nomor_urut++;

        // Validasi tidak boleh kosong
        if(member_name == ''){
          $('#member_name').addClass("is-invalid");
          return false;
        }

        if(member_address == ''){
          $('#member_address').addClass("is-invalid");
          return false;
        }

        if(member_phone == ''){
          $('#member_phone').addClass("is-invalid");
          return false;
        }
        
        $.ajax({
          url:"{{ route('member.add') }}",
          type:"POST",
          data:{
            member_code:member_code,
            member_name:member_name,
            member_address:member_address,
            member_phone:member_phone
          },
          success:function(response){
            if(response){

              alert("New Member Added!");
              
              $('#tableDT').append(`
                <tr>
                  <td class="td_norut">
                    ${nomor_urut}
                    <input type="text" id="nomor_urut" value="${nomor_urut}" hidden>
                  </td>  
                  
                  <td>${response.member_code}</td>
                  <td>${response.member_name}</td>
                  <td>${response.member_address}</td>
                  <td>${response.member_phone}</td>

                  <td class="text-center">
                      <a href="javascript:void(0)" onclick="editMember(${response.id})" class="btn btn-success btn-xs">
                          <i class="mdi mdi-table-edit"></i>
                      </a>

                      <a href="javascript:void(0)" onclick="deleteMember(${response.id})" class="btn btn-danger btn-xs">
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
  function editMember(id)
  {
    $.get('/member/' + id, function(member){
      $('#id').val(member.id);
      $('#member_code2').val(member.member_code);
      $('#member_name2').val(member.member_name);
      $('#member_address2').val(member.member_address);
      $('#member_phone2').val(member.member_phone);
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
    let member_code = $('#member_code2').val();
    let member_name = $('#member_name2').val();
    let member_address = $('#member_address2').val();
    let member_phone = $('#member_phone2').val();

    if(member_name == ''){
      $('#member_name2').addClass('is-invalid');
      return false;
    }

    if(member_address == ''){
      $('#member_address2').addClass('is-invalid');
      return false;
    }

    if(member_phone == ''){
      $('#member_phone2').addClass('is-invalid');
      return false;
    }

    $.ajax({
      url:"{{ route('member.update') }}",
      type:"PUT",
      data:{
        id:id,
        member_code:member_code,
        member_name:member_name,
        member_address:member_address,
        member_phone:member_phone
      },
      success:function(response){
        alert("Member Updated!");
        $('#sid' + response.id + ' td:nth-child(2)').text(response.member_code);
        $('#sid' + response.id + ' td:nth-child(3)').text(response.member_name);
        $('#sid' + response.id + ' td:nth-child(4)').text(response.member_address);
        $('#sid' + response.id + ' td:nth-child(5)').text(response.member_phone);
        $('#modal-edit').modal('toggle');
        $('#form-edit')[0].reset();
      }
    });

  });

</script>


<script>
  function deleteMember(id)
  {
    if(confirm("Do you want to delete this record?"))
    {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url:'/member/'+id,
        type:'DELETE',
        data:{},
        success:function(response){
          alert("Member has been deleted!");
          $('#sid'+id).remove();
        }
      });
    }
  }
</script>

  @endsection