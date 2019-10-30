@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Payments</h2>

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
	            			<th>Product</th>
	            			<th>Status</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($payments) || count($payments) == 0)
	            		<tr>
	            			<td colspan="4"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($payments as $key => $payment)
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>
	            				<b>{{$payment->customer->user->name}}</b><br>
	            				<span>{{$payment->customer->user->email}}</span>
	            			</td>
	            			<td>
	            				<b>{{$payment->product->name}}</b><br>
	            				<span>Rp. {{number_format($payment->product->price,2)}} / {{$payment->product->unit_value.' '.$payment->product->unit}}</span>
	            			</td>
	            			<td>
	            				@if($payment->product->price != 0)
		            				@if($payment->status == 0)
		            				<span class="badge badge-primary">The proof of payment is not uploaded yet.</span>
		            				@endif

		            				@if($payment->status == 1)
		            				<span class="badge badge-warning">Payment created</span>
		            				@endif

		            				@if($payment->status == 2)
		            				<span class="badge badge-success">Payment success</span>
		            				@endif

		            				@if($payment->status == 3)
		            				<span class="badge badge-danger">Payment declined. <br>The proof of payment not valid</span>
		            				@endif
		            			@else
		            				<span class="badge badge-success">Free</span>
	            				@endif
	            			</td>
	            			<td>
	            				@if($payment->product->price != 0)
		            				@if($payment->status == 1)
		            				<a href="javascript:void(0)" onclick="doConfirm('{{$payment->id}}',1)" class="btn z-techno-secondary z-techno-btn"><i class="fa fa-check"></i> Confirm</a>
		            				<a href="javascript:void(0)" onclick="doConfirm('{{$payment->id}}',0)" class="btn btn-danger z-techno-btn"><i class="fa fa-times"></i> Decline</a>

		            				<form method="post" action="{{route('admin.payment.confirm')}}" class="confirm-{{$payment->id}}">
		            					{{csrf_field()}}
		            					<input type="hidden" name="id" value="{{$payment->id}}">
		            				</form>
		            				<form method="post" action="{{route('admin.payment.decline')}}" class="decline-{{$payment->id}}">
		            					{{csrf_field()}}
		            					<input type="hidden" name="id" value="{{$payment->id}}">
		            				</form>
		            				<a href="{{Storage::url($payment->file_url)}}" target="_blank">See File</a>
		            				@endif
	            				@endif
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$payments->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
function doConfirm(id,status)
{
	const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn z-techno-btn z-techno-primary ml-2',
	    cancelButton: 'btn z-techno-btn z-techno-secondary'
	  },
	  buttonsStyling: false
	})

	var status_text = status ? 'confirm' : 'decline'

	swalWithBootstrapButtons.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Yes, '+status_text+' it!',
	  cancelButtonText: 'No, cancel!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	  	if(status)
	    	document.querySelector('.confirm-'+id).submit()
	    else
	    	document.querySelector('.decline-'+id).submit()
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelled',
	      'Your action has been canceled!',
	      'error'
	    )
	  }
	})
}
</script>
@endsection
