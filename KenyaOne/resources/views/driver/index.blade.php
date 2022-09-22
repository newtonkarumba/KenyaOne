@extends('layouts.sidebar')

@section('drivercontent')


{{-- add new tenants modal start --}}
<div class="modal fade" id="addTenantModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Tenant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_tenant_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname">First Name</label>
              <input type="text" name="fname" class="form-control" placeholder="First Name" required>
            </div>
            <div class="col-lg">
              <label for="lname">Last Name</label>
              <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" class="form-control" placeholder="Phone" required>
          </div>
          <div class="my-2">
            <label for="hseno">HseNo</label>
            <input type="text" name="hseno" class="form-control" placeholder="hseno" required>
          </div>
          <div class="my-2">
            <label for="avatar">Select Avatar</label>
            <input type="file" name="avatar" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_tenant_btn" class="btn btn-primary">Add Tenant</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new tenant modal end --}}

{{-- edit tenant modal start --}}
<div class="modal fade" id="editTenantModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Tenant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_tenant_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="emp_id" id="emp_id">
        <input type="hidden" name="emp_avatar" id="emp_avatar">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname">First Name</label>
              <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
            </div>
            <div class="col-lg">
              <label for="lname">Last Name</label>
              <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone" required>
          </div>
          <div class="my-2">
            <label for="hseno">HseNo</label>
            <input type="text" name="hseno" id="hseno" class="form-control" placeholder="hseno" required>
          </div>
          <div class="my-2">
            <label for="avatar">Select Avatar</label>
            <input type="file" name="avatar" class="form-control">
          </div>
          <div class="mt-2" id="avatar">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_tenant_btn" class="btn btn-success">Update Tenant</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit tenant modal end --}}

<body class="bg-light">
  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
<!-- CHANGE CARD COLOR AT bg-danger -->
          <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Tenant</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTenantModal"><i
                class="bi-plus-circle me-2"></i>Add New Tenant</button>
          </div>
          <div class="card-body" id="tenantsTable">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

<script>
//fetch all tenants 
fetchtenants();

function fetchtenants(){
  $.ajax({
    url: '{{ route('fetchAllTenants') }}',
    method: 'get',
    success:function(res){
      $("#tenantsTable").html(res);
      // $("table").DataTable({
      //         order: [0, 'desc']
      //       });
          
    }
  });
}




//edit tenant ajax request
$(document).on('click', '.editIcon', function(e){
    e.preventDefault();
    let id = $(this).attr('id');
    $.ajax({
       url: '{{ route('editTenant') }}',
       metod: 'get',
       data: {
        id: id,
        _token: '{{ csrf_token() }}'
        },
        success:function(res){
            $("#fname").val(res.first_name);
            $("#lname").val(res.last_name);
            $("#email").val(res.email);
            $("#phone").val(res.phone);
            $("#hseno").val(res.hseno);
            $("#avatar").html(
              `<img src="storage/images/${res.avatar}" width="100" class="img-fluid img-thumbnail">`);
            $("#emp_id").val(res.id);
            $("#emp_avatar").val(res.avatar);
        }
    });
    
  });

//delete tenant ajax request
$(document).on('click', '.deleteIcon', function(e){
  e.preventDefault();
  let id = $(this).attr('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ route('deleteTenants') }}',
            method: 'post',
            data: {
              id: id,
              _token: '{{ csrf_token() }}'
              
            },
            success:function(res){
              Swal.fire(
                  'Deleted!',
                  'Tenant has been deleted successfully.',
                  'success'
                )
                location.reload(); 
                fetchtenants();
            }
          });
        }
});

});


  //update tenant ajax request
$("#edit_tenant_form").submit(function(e){
  e.preventDefault();
  const fd = new FormData(this);
  $("#edit_tenant_btn").text('Updating.....');
  $.ajax({
    url: '{{ route('updateTenant') }}',
    method: 'post',
    data: fd,
    cache: false,
    processData: false,
    contentType: false,
   success:function(res){
      if (res.status == 200) {
              Swal.fire(
                'Updated!',
                'Tenant Updated Successfully!',
                'success'
              )
             location.reload(); 
             fetchtenants();
              } 
            $("#edit_tenant_btn").text('Update Tenant');
            $("#edit_tenant_form")[0].reset();
            $("#editTenantModal").modal('hide');
    }
  });

});

 
$("#add_tenant_form").submit(function(e){
  e.preventDefault();
  const fd = new FormData(this);
  $("#add_tenant_btn").text('Adding.....');
  $.ajax({
    url: '{{ route('store') }}',
    method: 'post',
    data: fd,
    cache: false,
    processData: false,
    contentType: false,
    success:function(res){
     if(res.status==200){
      swal.fire(
        'Added!',
        'Tenant Added Successfully!',
        'success'
      )
      location.reload(); 
      fetchtenants();
      
     }
     $("#add_tenant_btn").text('Add Tenant')
     $("#add_tenant_form")[0].reset();
     $("#addTenantModal").modal('hide');
    }
  });

  

});


</script>

@endsection
