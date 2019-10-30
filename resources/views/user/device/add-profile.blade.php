@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Add Profile</h2>
	            <form method="post" action="{{route('user.router.profiles.insert')}}" class="z-techno-form">
	            	{{csrf_field()}}
                    <input type="hidden" name="router_id" value="{{$router->id}}">
	            	<div class="form-group">
	            		<label>Profile Name</label>
	            		<input type="text" name="name" class="z-techno-el form-control {{$errors->has('name') ? 'is-invalid' : '' }}" value="{{old('name')}}">

                        @if($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Shared Users</label>
	            		<input type="number" class="z-techno-el form-control {{$errors->has('shared_users') ? 'is-invalid' : '' }}" name="shared_users" value="{{ old('shared_users') }}">

                        @if($errors->has('shared_users'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('shared_users') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
	            		<label>Rate Limit (rx/tx)</label>
                        <input type="text" class="z-techno-el form-control {{$errors->has('rate_limit') ? 'is-invalid' : '' }}" name="rate_limit" value="{{ old('rate_limit') }}">

                        @if($errors->has('rate_limit'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('rate_limit') }}</strong>
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
