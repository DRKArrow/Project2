@extends('Sale.master')

@section('content')
    <div class="row">
	  	@foreach($courses as $course)
			<div class="col l3 m6" style="min-width: 300px">
		      <div class="card white">
		        <div class="card-content">
		          <span class="card-title"><b>{{$course->name}}</b></span>
		          <span>{{$course->major}}</span>
		          <p>{{$course->class}} new class</p>
		        </div>
		        <div class="card-action grey lighten-5">
		          <a href="Class/classList/{{$course->course_id}}">See all class</a>
		        </div>
		      </div>
		    </div>
	  	@endforeach
	</div>
@endsection