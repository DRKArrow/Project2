@extends('Sale.master')

@section('css')
	<style>
		#cardtext {
			font-family: 'Barlow';
			opacity: 0;
			animation: blurFadeInOut 3s ease-in-out forwards;
		}
		.collap-anim {
			position: relative;
			animation: pop-in 1.5s ease-in-out forwards;
			opacity: 0;
		}
		.collapsible-header {
			font-weight: bold;
		}
		#maincard:hover {
			box-shadow: 2px 4px 8px rgba(0, 0, 0, .5);
		}
		@keyframes pop-in {
			from {
				opacity: 0;
				top: 60vh;
			}
			to {
				opacity:100;
				top: 0px;
			}
		}
		@keyframes blurFadeInOut {
			0% {
				opacity: 0;
				text-shadow: 0px 0px 40px #fff;
				-webkit-transform: scale(1.3);
			}
			25% {
				opacity: 1;
				text-shadow: 0px 0px 1px #fff;
				-webkit-transform: scale(1.3);
			}
			50% {
				opacity: 0;
				text-shadow: 0px 0px 40px #fff;
				-webkit-transform: scale(1.3);
			}
			100% {
				opacity: 1;
				text-shadow: 0px 0px 1px #fff;
				-webkit-transform: scale(1);
			}
		}
	</style>
@endsection

@section('content')
<div class="section"></div>
<div class="container">
	
	<div class="col s12">
		<div class="row">
	    	<img src="{{asset('images/major.jpg')}}" class="cover" />
		</div>
		<div class="row">
			@foreach($majors as $major)
			<div class="col s6">
				<ul class="collapsible collap-anim" id="{{$major->major_id}}">
					<li>
			    	 	<div class="collapsible-header"><i class="material-icons">collections</i>{{$major->major_name}}</div>
			 		 	<div class="collapsible-body" id="body-{{$major->major_id}}" style="background: white">
			 		 		<div class="preloader-wrapper small active" id="preloader-{{$major->major_id}}">
						      <div class="spinner-layer spinner-blue">
						        <div class="circle-clipper left">
						          <div class="circle"></div>
						        </div><div class="gap-patch">
						          <div class="circle"></div>
						        </div><div class="circle-clipper right">
						          <div class="circle"></div>
						        </div>
						      </div>

						      <div class="spinner-layer spinner-red">
						        <div class="circle-clipper left">
						          <div class="circle"></div>
						        </div><div class="gap-patch">
						          <div class="circle"></div>
						        </div><div class="circle-clipper right">
						          <div class="circle"></div>
						        </div>
						      </div>

						      <div class="spinner-layer spinner-yellow">
						        <div class="circle-clipper left">
						          <div class="circle"></div>
						        </div><div class="gap-patch">
						          <div class="circle"></div>
						        </div><div class="circle-clipper right">
						          <div class="circle"></div>
						        </div>
						      </div>

						      <div class="spinner-layer spinner-green">
						        <div class="circle-clipper left">
						          <div class="circle"></div>
						        </div><div class="gap-patch">
						          <div class="circle"></div>
						        </div><div class="circle-clipper right">
						          <div class="circle"></div>
						        </div>
						      </div>
						    </div>
			 		 	</div>
					</li>
				</ul>
			</div>
			@endforeach
		</div>
	</div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
@endsection

@section('js2')
	<script>
		$(document).ready(function(){
    		$('.collapsible').collapsible();
  		});
  		$('.collapsible').one('click',function(){
  			var major_id = $(this).attr('id');
 			var token = $("input[name='_token']").val();
 			var append = " ";
 			var count = 0;
  			//console.log(major_id);
  			$.ajax({
				url: '{{ url('Ajax/getCourses_classList') }}',
				method: 'get',
				data: { 
						id: major_id,
						_token: token
				},
				beforeSend: function(){
			         $('#preloader-'+major_id).show();
			    },
				success: function(data) {
					$.when($('#preloader-'+major_id).fadeOut()).done(function(){
						if(data.length==0)
						{
							append = '<div class="row margin"><h6>There are no courses available</h6></div>';
						}else
						{
							for(var i=0;i<data.length;i++)
							{
								if(data[i].count>0)
								{
									append += '<div class="row margin"><h6><i class="material-icons">book</i> &nbsp;' + data[i].course_name + ' <a href="classList/' + data[i].course_id + '">(' + data[i].count + ' class available)</a> </h6></div>';
								}else 
								{
									append += '<div class="row margin"><h6><i class="material-icons">book</i> &nbsp;' + data[i].course_name + ' (' + data[i].count + ' class available) </h6></div>';
								}
						 		
							}
						}
						$('#body-'+major_id).append(append);
					});	
				},
			});
  		});
  	</script>
@endsection