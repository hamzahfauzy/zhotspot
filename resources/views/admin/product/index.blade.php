@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Products</h2>

	            <a href="{{route('admin.product.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create</a>
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
	            			<th>Name</th>
	            			<th>Price (Rp)</th>
	            			<th>Unit</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($products) || count($products) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($products as $key => $product)
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>{{$product->name}}</td>
	            			<td>{{number_format($product->price,2)}}</td>
	            			<td>{{$product->unit_value}} {{$product->unit}}</td>
	            			<td>
	            				<a href="{{route('admin.product.edit',$product->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
	            				<a href="{{route('admin.product.delete')}}" onclick="event.preventDefault(); deleteAlert('{{$product->id}}')" class="btn btn-danger z-techno-btn"><i class="fa fa-trash"></i> Delete</a>

	            				<form method="post" action="{{route('admin.product.delete')}}" class="form-delete-{{$product->id}}">
	            					{{csrf_field()}}
	            					<input type="hidden" name="_method" value="DELETE">
	            					<input type="hidden" name="id" value="{{$product->id}}">
	            				</form>


	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$products->links()}}
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
