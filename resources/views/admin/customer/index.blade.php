@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Customers</h2>

	            <!-- <a href="{{route('admin.customer.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create</a> -->
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
	            			<th>Customer</th>
	            			<th>Subscription</th>
	            			<th>Status</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($customers) || count($customers) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($customers as $key => $customer)
	            		<?php $subscription = $customer->subscription()->orderBy('id','desc')->first(); ?>
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>
	            				<b>{{$customer->user->name}}</b><br>
	            				<span>{{$customer->user->email}}</span><br>
	            				<span>{{$customer->address}} - {{$customer->phone}}</span><br>
	            			</td>
	            			<td>
	            				@if(!empty($subscription))
	            				{{$subscription->payment->product->name.' / Rp. '.number_format($subscription->payment->product->price,2)}} <br>
	            				<b>Start at : </b><br>
	            				{{$subscription->created_at}}
	            				@else
	            				-
	            				@endif
	            			</td>
	            			<td>
	            				@if(!empty($subscription))
		            				@if($subscription->status == 1)
		            				<span class="badge badge-success">Active</span>
		            				@elseif($subscription->status == 2)
		            				<span class="badge badge-danger">Expired</span>
		            				@elseif($subscription->status == 3)
		            				<span class="badge badge-warning">Deactive</span>
		            				@else
		            				<span class="badge badge-primary">Not Active</span>
		            				@endif
		            			@else
		            				<span class="badge badge-primary">Not Active</span>
	            				@endif
	            			</td>
	            			<td>
	            				@if(!empty($subscription))
		            				@if($subscription->status == 2)
		            				<a href="javascript:void(0)" onclick="event.preventDefault(); activateAlert('{{$customer->id}}')" class="btn z-techno-secondary z-techno-btn"><i class="fa fa-check"></i> Activate</a>

		            				<form method="post" action="{{route('admin.customer.activate')}}" class="form-activate-{{$customer->id}}">
		            					{{csrf_field()}}
		            					<input type="hidden" name="_method" value="PUT">
		            					<input type="hidden" name="id" value="{{$customer->id}}">
		            				</form>
		            				@endif

		            				@if($subscription->status == 1)
		            				<a href="javascript:void(0)" onclick="event.preventDefault(); deactivateAlert('{{$customer->id}}')" class="btn btn-danger z-techno-btn"><i class="fa fa-times"></i> Deactivate</a>

		            				<form method="post" action="{{route('admin.customer.deactivate')}}" class="form-deactivte-{{$customer->id}}">
		            					{{csrf_field()}}
		            					<input type="hidden" name="_method" value="PUT">
		            					<input type="hidden" name="id" value="{{$customer->id}}">
		            				</form>
		            				@endif
	            				@endif
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$customers->links()}}
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
</script>
@endsection
