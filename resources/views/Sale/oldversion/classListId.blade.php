@extends('Sale.master')

@section('css')
	<style>
		.dropdown-content {
		    max-height: 200px;
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
		.collapsible {
			min-width: 300px;
		}
	</style>
@endsection

@section('content')
<div class="section"></div>
<div class="container">

	<div class="col s12">
		<div class="row">
	    	<img src="{{asset('images')}}/{{$major->major_name}}.jpg" class="cover" />
		</div>
		<div class="row">
			@foreach($classes as $class)
			<div class="col l6 m12">
				<ul class="collapsible collap-anim" id="{{$class->class_id}}">
					<li>
			    	 	<div class="collapsible-header"><i class="material-icons">collections</i>{{$class->class_name}}</div>
			 		 	<div class="collapsible-body" id="body-{{$class->class_id}}" style="background: white">
			 		 		<div class="preloader-wrapper small active" id="preloader-{{$class->class_id}}">
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

			<div id="modal-{{$class->class_id}}" class="modal">
				<div class="modal-content">
					<div class="container">
						<div class="row margin">
							<div class="input-field col s4 offset-s4">
								<form method="post" action="{{route('addStudentIntoClass')}}" id="addStudent-{{$class->class_id}}">
									@csrf
									<select name="ddlStudent" id="selectStudent-{{$class->class_id}}">
										<option disabled selected>Student name</option>
										@foreach($students as $student)
											<option value="{{$student->student_id}}">{{$student->student_name}}</option>
										@endforeach
									</select>
									<input type="hidden" name="class_id" value="{{$class->class_id}}">
								</form>
							</div>
						</div>
						<div class="row margin" id="table-{{$class->class_id}}">

						</div>
						<div class="section"></div>
						<div class="row margin center-align">
							<button type="button" class="modal-close waves-effect waves-green btn" id="abc-{{$class->class_id}}">Add</button>
						</div>
					</div>
			    </div>
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
    		$('.modal').modal();
  		});

  		$('.collapsible').one('click',function(){
  			var class_id = $(this).attr('id');
 			var token = $("input[name='_token']").val();
 			var append = " ";
  			//console.log(class_id);
  			$.ajax({
				url: '{{ url('Ajax/getStudent') }}',
				method: 'get',
				data: { 
						id: class_id,
						_token: token
				},
				beforeSend: function(){
			         $('#preloader-'+class_id).show();
			    },
				success: function(data) {
					//console.log(data);
					$.when($('#preloader-'+class_id).fadeOut()).done(function(){
						if(data.length==0)
						{
							append = '<div class="row margin"><h6>There are no students in this class</h6></div>';
							append += '<a class="btn-floating waves-effect waves-light blue right modal-trigger" href="#modal-' + class_id + '"><i class="material-icons">add</i></a>'
						}else 
						{
							append += '<table class="highlight"><thead><tr><th></th><th>Name</th><th>Phone</th><th>Email</th><th>Added by</th></tr></thead><tbody>';
							for(var i=0;i<data.length;i++)
							{
								var j = i+1;
								append += '<tr><th>' + j + '</th><td>' + data[i].student_name + '</td><td>' + data[i].student_phone +'</td><td>' + data[i].student_email + '</td><th>' + data[i].sale_name + '</th></tr>';
							}
							append += '</tbody></table>';
							append += '<a class="btn-floating waves-effect waves-light blue right modal-trigger" href="#modal-' + class_id + '"><i class="material-icons">add</i></a>'
						}
						$('#body-'+class_id).append(append);
					});
				},
			});
  		});

  		@foreach($classes as $class)
  		$('#selectStudent-'+{{$class->class_id}}).change(function(){
  			var token = $("input[name='_token']").val();
  			var student_id = $(this).val();
  			var append = " ";
  			//console.log(student_id);
  			$.ajax({
  				url: '{{ url('Ajax/getStudentName') }}',
  				method: 'get',
  				data: {
  						id: student_id,
  						_token: token
  				},
  				success: function(data) {
  					//console.log(data[0].student_name);
  					append += '<blockquote><p>Phone: ' + data.student_phone  + '</p>';
  					append += '<p>Email: ' + data.student_email + '</p></blockquote>';
  					$('#table-'+{{$class->class_id}}).html(" ");
  					$('#table-'+{{$class->class_id}}).append(append);
  				},
  			});
  		});
  		@endforeach

  		@foreach($classes as $class)
  		$('#abc-'+{{$class->class_id}}).click(function(){
  			var student_id = $('#selectStudent-'+{{$class->class_id}}).val();
  			var class_id = {{$class->class_id}};
  			//console.log(id);
  			$.ajax({
  				url: '{{ url('Ajax/CheckStudent') }}',
  				method: 'get',
  				data: {
  						_token: $('input[name=_token]').val(),
  						student_id: student_id,
  						class_id: class_id
  				},
  				success: function(data){
  					// console.log(data);
  					if(data.count > 0)
  					{
  						toastr.error("This student already in this class!");
  					}else if(data.checkTime > 0)
  					{
  						if(data.check > 0)
  						{
  							toastr.error("This student is busy!");
  						}
  					}else
					{
						$('#addStudent-'+{{$class->class_id}}).submit();
					}
  				},
  			});
  		});
  		@endforeach
	</script>
@endsection