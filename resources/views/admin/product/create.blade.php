@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Create Products</h2>
	            <form method="post" action="{{route('admin.product.insert')}}" class="z-techno-form">
	            	{{csrf_field()}}
	            	<div class="form-group">
	            		<label>Product Name</label>
	            		<input type="name" class="z-techno-el form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">

                        @if($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Price</label>
	            		<input type="number" class="z-techno-el form-control {{$errors->has('price') ? 'is-invalid' : '' }}" name="price" value="{{ old('price') }}">

                        @if($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Unit</label>
	            		<input type="text" class="z-techno-el form-control {{$errors->has('unit') ? 'is-invalid' : '' }}" name="unit" value="{{ old('unit') }}">

                        @if($errors->has('unit'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('unit') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Unit Value</label>
	            		<input type="number" class="z-techno-el form-control {{$errors->has('unit_value') ? 'is-invalid' : '' }}" name="unit_value" value="{{ old('unit_value') }}">

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
