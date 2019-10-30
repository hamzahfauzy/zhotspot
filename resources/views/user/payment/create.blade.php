@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Create Payment</h2>
            <div style="max-width: 500px;">
            <form method="post" action="{{route('user.payment.insert')}}">
            	{{csrf_field()}}
            	<div class="form-group">
            		<label>Product</label>
            		<select name="product" class="z-techno-el form-control {{$errors->has('product') ? 'is-invalid' : '' }}">
            			<option value="">-Choose Product-</option>
            			@foreach($products as $product)
            			<option value="{{$product->id}}">{{$product->name}} (Rp. {{$product->price}} / {{$product->unit_value.' '.$product->unit}})</option>
            			@endforeach
            		</select>
            		@if ($errors->has('product'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('product') }}</strong>
                        </span>
                    @endif
            	</div>
            	<button class="btn z-techno-btn z-techno-primary"><i class="fa fa-save"></i> Submit</button>
                <a href="{{route('user.payment.index')}}" class="btn z-techno-secondary z-techno-btn"><i class="fa fa-arrow-left"></i> Back</a>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection