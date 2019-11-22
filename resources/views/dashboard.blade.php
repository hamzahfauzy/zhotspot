@extends('layouts.dashboard')
@section('home-active','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<h1>Your System Dashboard</h1>
            <div class="card" style="width: 18rem;">
			  <div class="card-body">
			    <h5 class="card-title">Routers</h5>
			    <h1 class="card-text">{{$routers}}</h1>
			    <a href="{{route('user.router.index')}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> View</a>
			  </div>
			</div>
        </div>
    </div>
</div>
@endsection