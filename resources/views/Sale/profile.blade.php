@extends('Sale.newmaster')

@section('title')
	My Profile
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('css/dropify.min.css')}}" type="text/css">
@endsection

@section('content')
<div class="container">
	<div class="section"></div>
	<div class="card">
		<form enctype="multipart/form-data" action="{{route('changeAvatar')}}" method="post">
			@csrf
			<div class="row">
				<div class="col s12 m12 l12">
	                	<input type="file" name="avatar" class="dropify" data-height="250px" data-default-file="{{asset($profile->sale_avatar)}}" data-show-remove="false">
	            </div>
			</div>
			<div class="row">
				<div class="col s12 center-align">
					<h4>{{$profile->sale_name}}</h4>
					<h6>{{$profile->sale_email}}</h6>
					<h6>{{$profile->sale_phone}}</h6>
				</div>
				<div class="col s12 center-align">
					<button class="btn waves-effect waves-light waves-cyan">Change avatar</button>
				</div>
			</div>
		</form>
		<div class="section"></div>
	</div>
</div>
@endsection

@section('js')
	<script type="text/javascript" src="{{asset('js/dropify.min.js')}}"></script>
@endsection

@section('js2')
	<script>
		$(document).ready(function(){
			$('.dropify').dropify();
		});
	</script>
@endsection