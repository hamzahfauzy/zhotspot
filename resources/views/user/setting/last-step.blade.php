@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Last Step Register</h2>
            <div style="max-width: 500px;">
            <form method="post" action="{{route('user.save-last-step')}}">
            	{{csrf_field()}}
            	<div class="form-group">
            		<label>Address</label>
            		<textarea name="address" class="z-techno-el form-control {{$errors->has('address') ? 'is-invalid' : '' }}" style="resize: none;"></textarea>
            		@if ($errors->has('address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
            	</div>

            	<div class="form-group">
            		<label>Phone Number</label>
            		<input type="text" name="phone" class="z-techno-el form-control {{$errors->has('phone') ? 'is-invalid' : '' }}"/>
            		@if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
            	</div>

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
            </form>
            </div>
        </div>
    </div>
</div>
@endsection