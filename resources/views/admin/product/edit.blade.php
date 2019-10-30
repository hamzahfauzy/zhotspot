@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Update Products</h2>
	            <form method="post" action="{{route('admin.product.update')}}" class="z-techno-form">
	            	{{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$product->id}}">
	            	<div class="form-group">
	            		<label>Product Name</label>
	            		<input type="name" class="z-techno-el form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $product->name }}">

                        @if($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Price</label>
	            		<input type="number" class="z-techno-el form-control {{$errors->has('price') ? 'is-invalid' : '' }}" name="price" value="{{ old('price') ? old('price') : $product->price }}">

                        @if($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Unit</label>
	            		<input type="text" class="z-techno-el form-control {{$errors->has('unit') ? 'is-invalid' : '' }}" name="unit" value="{{ old('unit') ? old('unit') : $product->unit }}">

                        @if($errors->has('unit'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('unit') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Unit Value</label>
	            		<input type="number" class="z-techno-el form-control {{$errors->has('unit_value') ? 'is-invalid' : '' }}" name="unit_value" value="{{ old('unit_value') ? old('unit_value') : $product->unit_value }}">

                        @if($errors->has('unit_value'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('unit_value') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<button class="btn z-techno-btn z-techno-primary"><i class="fa fa-save"></i> Submit</button>
	            	<a href="{{route('admin.product.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
