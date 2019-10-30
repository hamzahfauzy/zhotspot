@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Create Devices</h2>
	            <form method="post" action="{{route('user.router.insert')}}" class="z-techno-form">
	            	{{csrf_field()}}
	            	<div class="form-group">
	            		<label>Router Name</label>
	            		<input type="name" class="z-techno-el form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">

                        @if($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Router Username</label>
	            		<input type="text" class="z-techno-el form-control {{$errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}">

                        @if($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Router Password</label>
	            		<input type="password" class="z-techno-el form-control {{$errors->has('password') ? 'is-invalid' : '' }}" name="password" value="{{ old('password') }}">

                        @if($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<button class="btn z-techno-btn z-techno-primary"><i class="fa fa-save"></i> Submit</button>
	            	<a href="{{route('user.router.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
