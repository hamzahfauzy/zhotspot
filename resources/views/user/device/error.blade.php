@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
        		<h2>Error. RouterOS not Connected</h2>
			      <div class="alert alert-danger alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			        <strong>Your router is not connected to this application. Please check the installation instruction.</strong>
			      </div>
	        </div>
        </div>
    </div>
</div>
@endsection
