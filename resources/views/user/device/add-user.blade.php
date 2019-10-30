@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Create User Router {{$router->name}}</h2>
	            <form method="post" action="{{route('user.router.users.insert')}}" class="z-techno-form">
	            	{{csrf_field()}}
                    <input type="hidden" name="router_id" value="{{$router->id}}">
	            	<div class="form-group">
	            		<label>Profile Name</label>
                        <select class="z-techno-el form-control {{$errors->has('username') ? 'is-invalid' : '' }}" name="profile">
                            @foreach($responses as $response)
                            @if ($response->getType() === PEAR2\Net\RouterOS\Response::TYPE_DATA)
                            <option value="{{$response->getProperty('name')}}">{{$response->getProperty('name')}}</option>
                            @endif
                            @endforeach
                        </select>
	            		@if($errors->has('profile'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('profile') }}</strong>
                            </span>
                        @endif
	            	</div>

	            	<div class="form-group">
                        <label>Name</label>
                        <input type="text" class="z-techno-el form-control {{$errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">

                        @if($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="z-techno-el form-control {{$errors->has('password') ? 'is-invalid' : '' }}" name="password" value="{{ old('password') }}">

                        @if($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary"><i class="fa fa-save"></i> Submit</button>
	            	<a href="{{route('user.router.users',$router->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
