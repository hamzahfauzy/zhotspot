@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Payments</h2>

	            <a href="{{route('user.payment.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create</a>
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
	            				<b>{{$payment->product->name}}</b><br>
	            				<span>Rp. {{number_format($payment->product->price,2)}} / {{$payment->product->unit_value.' '.$payment->product->unit}}</span>
	            			</td>
	            			<td>
	            				@if($payment->product->price != 0)
		            				@if($payment->status == 0)
		            				<span class="badge badge-primary">Please upload the proof of payment</span>
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
		            				@if($payment->status == 0)
		            				<form method="post" action="{{route('user.payment.upload')}}" enctype="multipart/form-data" class="form-upload-{{$payment->id}}">
		            					{{csrf_field()}}
		            					<input type="hidden" name="_method" value="PUT">
		            					<input type="hidden" name="id" value="{{$payment->id}}">
		            					<button type="button" class="btn z-techno-secondary z-techno-btn" onclick="openFileExplorer('{{$payment->id}}')"><i class="fa fa-cloud-upload"></i> Upload</button>
		            					<div class="form-group" style="height: 0px;overflow: hidden;">
		            						<input id="file-{{$payment->id}}" type="file" name="file" class="form-control" style="height: auto;" onchange="upload('{{$payment->id}}')">
		            					</div>
		            				</form>
		            				@else
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
var _file = ''
function openFileExplorer(id)
{
	document.querySelector('#file-'+id).click()
}

function upload(id)
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
	  confirmButtonText: 'Yes, upload proof!',
	  cancelButtonText: 'No, cancel!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	    document.querySelector('.form-upload-'+id).submit()
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelled',
	      'Your proof of payment not uploaded :)',
	      'error'
	    )
	  }
	})
}
</script>
@endsection
