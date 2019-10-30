@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Routers</h2>

	            <a href="{{route('user.router.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create</a>
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
	            			<th>Username</th>
	            			<th>Installation Script</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($devices) || count($devices) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($devices as $key => $device)
	            		<!-- Modal -->
	            		@if($device->pptp_user != '')
						<div class="modal fade" id="exampleModal{{$device->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">{{$device->name}} Installation Script</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						      	Copy this script below to your RouterOS terminal<br>
						      	Step 1 <br>
						        <code>
						        	<!-- tool fetch url="{{URL::to('/')}}/installation/{{$device->token}}" dst-path={{str_replace(' ','',$device->name)}}.zins mode=http -->
						        	/interface pptp-client add name={{str_replace(' ','',$device->name)}} user={{$device->pptp_user}} password={{$device->pptp_password}} connect-to=103.15.242.82 disabled=no
						        </code>
						        <br>
						        <!-- Step 2<br>
						        <code>
						        	import {{str_replace(' ','',$device->name)}}.zins
						        </code> -->
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>
						@endif
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>{{$device->name}}</td>
	            			<td>
	            				{{$device->username}}
	            			</td>
	            			<td>
	            				@if($device->pptp_user == '')
	            					Wait for installation script
	            				@else
	            					<a href="#" data-toggle="modal" data-target="#exampleModal{{$device->id}}">See Installation Script</a>
	            				@endif
	            			</td>
	            			<td>
	            				@if($device->pptp_user != '')
	            				<a href="{{route('user.router.users',$device->id)}}" class="btn z-techno-primary z-techno-btn"><i class="fa fa-eye"></i> Users</a>
	            				<a href="{{route('user.router.profiles',$device->id)}}" class="btn btn-primary z-techno-btn"><i class="fa fa-child"></i> Profiles</a>
	            				@endif
	            				<a href="{{route('user.router.edit',$device->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
	            				<a href="{{route('user.router.delete')}}" onclick="event.preventDefault(); deleteAlert('{{$device->id}}')" class="btn btn-danger z-techno-btn"><i class="fa fa-trash"></i> Delete</a>

	            				<form method="post" action="{{route('user.router.delete')}}" class="form-delete-{{$device->id}}">
	            					{{csrf_field()}}
	            					<input type="hidden" name="_method" value="DELETE">
	            					<input type="hidden" name="id" value="{{$device->id}}">
	            				</form>


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
