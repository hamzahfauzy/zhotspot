@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Patch Profile {{$profile}}</h2>
	            <form method="post" action="{{route('user.router.profiles.save-patch')}}" class="z-techno-form">
	            	{{csrf_field()}}
                    <input type="hidden" name="router_id" value="{{$router->id}}">
	            	<div class="form-group">
	            		<label>Profile Name</label>
	            		<input type="text" name="name" class="z-techno-el form-control" value="{{ $profile }}" readonly="">
	            	</div>

	            	<div class="form-group">
	            		<label>Masa Aktif</label>
	            		<input type="number" class="z-techno-el form-control {{$errors->has('masa_aktif') ? 'is-invalid' : '' }}" name="masa_aktif" value="{{ old('masa_aktif') }}">

                        @if($errors->has('masa_aktif'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('masa_aktif') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Satuan</label>
                        <select class="z-techno-el form-control {{$errors->has('satuan') ? 'is-invalid' : '' }}" name="satuan">
                            @foreach(['h' => 'Jam', 'd' => 'Hari'] as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>

                        @if($errors->has('satuan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('satuan') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<button class="btn z-techno-btn z-techno-primary"><i class="fa fa-save"></i> Submit</button>
	            	<a href="{{route('user.router.profiles',$router->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
