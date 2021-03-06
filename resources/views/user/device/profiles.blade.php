@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Profiles Router {{$router->name}}</h2>

	            <a href="{{route('user.router.profiles.create',$router->id)}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Add Profile</a>
	            <p></p>
	            @if ($message = Session::get('success'))
			      <div class="alert alert-success alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{!! $message !!}</strong>
			      </div>
			    @endif

			    @if ($message = Session::get('error'))
			      <div class="alert alert-danger alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{!! $message !!}</strong>
			      </div>
			    @endif
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th>#</th>
	            			<th>Name</th>
	            			<th>Shared Users</th>
	            			<th>Rate Limit (rx/tx)</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($responses) || count($responses) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach ($responses as $key => $response)
	            		@if ($response->getType() === PEAR2\Net\RouterOS\Response::TYPE_DATA)
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>
	            				{{$response->getProperty('name')}}
	            			</td>
	            			<td>
	            				{{$response->getProperty('shared-users')}}
	            			</td>
	            			<td>
	            				{{$response->getProperty('rate-limit')}}
	            			</td>
	            			<td>
	            				<a href="{{route('user.router.profiles.patch',[$router->id, $response->getProperty('name')])}}" class="btn z-techno-btn btn-primary"><i class="fa fa-code-fork"></i> Patch</a>
	            				<a href="{{route('user.router.profiles.edit',[$router->id, $response->getProperty('name')])}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
	            				<a href="javascript:void(0)" onclick="deleteAlert('{{$response->getProperty('name')}}')" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
	            				<form method="post" action="{{route('user.router.profiles.delete')}}" class="form-delete-{{$response->getProperty('name')}}">
	            					{{csrf_field()}}
	            					<input type="hidden" name="_method" value="DELETE">
	            					<input type="hidden" name="router_id" value="{{$router->id}}">
	            					<input type="hidden" name="name" value="{{$response->getProperty('name')}}">
	            				</form>
	            			</td>
	            		</tr>
	            		@endif
	            		@endforeach
	            	</table>
	            </div>
	        </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
function activateAlert(id)
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
	  confirmButtonText: 'Yes, activate it!',
	  cancelButtonText: 'No, cancel!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	    document.querySelector('.form-activate-'+id).submit()
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelled',
	      'Customer is still deactive',
	      'error'
	    )
	  }
	})
}

function deactivateAlert(id)
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
	  confirmButtonText: 'Yes, deactivate it!',
	  cancelButtonText: 'No, cancel!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	    document.querySelector('.form-deactivate-'+id).submit()
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelled',
	      'Customer is still active',
	      'error'
	    )
	  }
	})
}


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
	      'User is still exists :)',
	      'error'
	    )
	  }
	})
}
</script>
@endsection
