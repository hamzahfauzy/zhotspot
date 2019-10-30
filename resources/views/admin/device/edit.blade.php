@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Update Router</h2>
	            <form method="post" action="{{route('admin.router.update')}}" class="z-techno-form">
	            	{{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$device->id}}">
	            	<div class="form-group">
	            		<label>Router Name</label>
	            		<input type="name" class="z-techno-el form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ $device->name }}" readonly="">
	            	</div>

	            	<div class="form-group">
                        <label>Router PPTP Username</label>
                        <input type="text" class="z-techno-el form-control {{$errors->has('pptp_user') ? 'is-invalid' : '' }}" name="pptp_user" value="{{ old('pptp_user') ? old('pptp_user') : $device->pptp_user }}">

                        @if($errors->has('pptp_user'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pptp_user') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Router PPTP Password</label>
                        <input type="password" class="z-techno-el form-control {{$errors->has('pptp_password') ? 'is-invalid' : '' }}" name="pptp_password" value="{{ old('pptp_password') ? old('pptp_password') : $device->pptp_password }}">

                        @if($errors->has('pptp_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pptp_password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Router PPTP IP Address</label>
                        <input type="text" class="z-techno-el form-control {{$errors->has('ip_address') ? 'is-invalid' : '' }}" name="ip_address" value="{{ old('ip_address') ? old('ip_address') : $device->ip_address }}">

                        @if($errors->has('ip_address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ip_address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>PPTP CHAP Secret Line</label>
                        <input type="text" class="z-techno-el form-control {{$errors->has('chap_secret_line') ? 'is-invalid' : '' }}" name="chap_secret_line" value="{{ old('chap_secret_line') ? old('chap_secret_line') : $device->chap_secret_line }}">

                        @if($errors->has('chap_secret_line'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('chap_secret_line') }}</strong>
                            </span>
                        @endif
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary"><i class="fa fa-save"></i> Submit</button>
	            	<a href="{{route('admin.router.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
