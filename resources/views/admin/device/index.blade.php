@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Routers</h2>

	            <p></p>
	            @if ($message = Session::get('success'))
			      <div class="alert alert-success alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{{ $message }}</strong>
			      </div>
			    @endif
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th>#</th>
	            			<th>Customer</th>
	            			<th>Router Name</th>
	            			<th>PPTP Username</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($devices) || count($devices) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($devices as $key => $device)
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>{{$device->customer->user->name}}</td>
	            			<td>{{$device->name}}</td>
	            			<td>{{$device->pptp_user}}</td>
	            			<td>
	            				<a href="{{route('admin.router.users',$device->id)}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-eye"></i> See Users</a>
	            				<a href="{{route('admin.router.edit',$device->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>

	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$devices->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
function deleteAlert(id)
{
	const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn z-techno-btn z-techno-primary ml-2',
	    cancelButton: 'btn z-techno-btn z-techno-secondary'
	  },
	  buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Yes, delete it!',
	  cancelButtonText: 'No, cancel!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	    document.querySelector('.form-delete-'+id).submit()
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelled',
	      'Your imaginary data is safe :)',
	      'error'
	    )
	  }
	})
}
</script>
@endsection
