@extends('Sale.master')
@section('css')
	<style>
		#div_select_2-1, #div_select_3-1, #div_select_2-2, #div_select_3-2, #submit-1, #submit-2 {
			display:none;
		}
		.card {
	    	padding:30px;
	    	border-radius: 2px;
	    }
		#divselect1, #divselect2 {
			position: relative;
		}
		#divifcheck1, #divifcheck2, .anotherchoice, #interest {
			display:none;
		}
	    @keyframes selected1 {
	    	from {
	    		-webkit-transform: translateX(0);
	    	}
	    	to {
	    		-webkit-transform: translateX(90px);
	    	}
	    }
	    @keyframes selected2 {
	    	from {
	    		-webkit-transform: translateX(0);
	    	}
	    	to {
	    		-webkit-transform: translateX(-90px);
	    	}
	    }
	</style>
@endsection
@section('content')
<div class="section"></div>
<div class="container">
	<div class="card">
		<div class="col s12">
			<div class="row margin">
				<div class="col s5 offset-s1 right-align" id="divselect1">
					<label id="selection1">
						<input type="checkbox" id="select1">
						<span>Select a student</span>
					</label>
				</div>
				<div class="col" id="or">
					<span id="selectionor">or</span>
				</div>
				<div class="col s5 left-align" id="divselect2">
					<label id="selection2">
						<input type="checkbox" id="select2">
						<span>Add a new one</span>
					</label>
				</div>				
			</div>
			<div class="row margin anotherchoice" id="anotherchoice1">
				<div class="col s12 right-align">
					<label>
						<input type="checkbox" id="choice1">
						<span>Add a new one</span>
					</label>
				</div>
			</div>
			<div class="row margin anotherchoice" id="anotherchoice2">
				<div class="col s12 right-align">
					<label>
						<input type="checkbox" id="choice2">
						<span>Select a student</span>
					</label>
				</div>
			</div>
			
				<div class="row margin" id="divifcheck1">
					<form method="post" action="{{route('addInterest')}}">
						@csrf
						<div class="container">
							<select id="ifcheck1" name="ddlStudent">
								<option value="default" selected disabled>Select a student</option>
								@foreach($students as $student)
									<option value="{{$student->student_id}}">{{$student->student_name}}</option>
								@endforeach
							</select>
						<div id="selectStudent" class="row margin"></div>
						</div>
						<div class="container">
							<div class="row margin" id="interest">
								<div class="input-field col s12 center-align">
									<h5>Student interesting in</h5>
								    <select id="select_1-1" class="">
								    	<option value="0" selected disabled>Majors</option>
								    	@foreach($majors as $major)
								    		<option value="{{$major->major_id}}">{{$major->major_name}}</option>
								    	@endforeach
								    </select>
								  
								    <div class="input-field col s6 center-align" id="div_select_2-1">
									    <select id="select_2-1" name="ddlCourse">
									    </select>
							   		 </div>
							   		 <div class="input-field col s6 center-align" id="div_select_3-1">
									    <select id="select_3-1" name="ddlSchedule">
									    </select>
							   		 </div>
							    </div> 
							</div>
							<div class="row margin center-align" id="submit-1">
								<button class="btn" type="submit" onclick="return checkInterest($('#ifcheck1').val())">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="container">
					<div class="row margin" id="divifcheck2">
						<form method="post" action="{{route('addInterestNew')}}" accept-charset="UTF-8" class="login-form">
					 		@csrf
						  	<div class="row margin">
							    <div class="input-field col s12">
							      <input id="name" name="txtName" type="text" data-length="30" class="textcounter">
							      <label for="name" class="center-align"><i class="material-icons">person_outline</i> Name</label>
							    </div>
							</div>
						  	<div class="row margin">
							    <div class="input-field col s12">
							      <input id="phone" name="txtPhone" type="text" data-length="15" class="textcounter">
							      <label for="phone"><i class="material-icons">local_phone</i> Phone</label>
							    </div>
						   	</div>
						   	<div class="row margin">
							    <div class="input-field col s12">
							      <input id="email" name="txtEmail" type="email">
							      <label for="email"><i class="material-icons">email</i> Email</label>
							    </div>
							</div>
							<div class="row margin">
								<div class="input-field col s12 center-align">
									<h5>Student interesting in</h5>
								    <select id="select_1-2">
								    	<option value="0" selected disabled>Majors</option>
								    	@foreach($majors as $major)
								    		<option value="{{$major->major_id}}">{{$major->major_name}}</option>
								    	@endforeach
								    </select>
								  
								    <div class="input-field col s6 center-align" id="div_select_2-2">
									    <select id="select_2-2" name="ddlCourse">
									    </select>
							   		 </div>
							   		 <div class="input-field col s6 center-align" id="div_select_3-2">
									    <select id="select_3-2" name="ddlSchedule">
									    </select>
							   		 </div>
							    </div> 
							</div>
							<div class="row margin center-align" id="submit-2">
								<button class="btn" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
		 </div>
	</div>
</div>
@endsection
@section('js2')
	<script type="text/javascript">	
		$('#select1').click(function(){
			$('#select2').attr('disabled',true);
			$('#selectionor').fadeOut();
			$('#selection2').fadeOut();
			$.when($('#divselect1').css('animation','selected1 1.5s both').delay(500).fadeOut()).done(function(){
				$('#divifcheck1').fadeIn(1300);
				$('#anotherchoice1').fadeIn(1300);
			});
		});

		$('#select2').click(function(){
			$('#select1').attr('disabled',true);
			$('#selectionor').fadeOut();
			$('#selection1').fadeOut();
			$.when($('#divselect2').css('animation','selected2 1.5s both').delay(500).fadeOut()).done(function(){
				$('#divifcheck2').fadeIn(1300);
				$('#anotherchoice2').fadeIn(1300);
			});
		});	

		$('#choice1').click(function(){
			$('#divifcheck1').fadeOut();
			$.when($('#anotherchoice1').fadeOut()).done(function(){
				$('#choice1').prop('checked',false);
				$('#divifcheck2').fadeIn(1300);
				$('#anotherchoice2').fadeIn(1300);
				$('#ifcheck1 option[value=default]').prop('selected',true);
				$('#ifcheck1').formSelect();
				$('#selectStudent').html(" ");
				$('#interest').fadeOut();
				$('#select_1-1').val('0');
				$('#select_2-1').val('0');
				$('#select_3-1').val('0');
				$('#select_1-1').formSelect();
				$('#select_2-1').formSelect();
				$('#select_3-1').formSelect();
				$('#div_select_2-1').hide();
				$('#div_select_3-1').hide();
				$('#submit-1').hide();
			});
		});

		$('#choice2').click(function(){
			$('#divifcheck2').fadeOut();
			$.when($('#anotherchoice2').fadeOut()).done(function(){
				$('#choice2').prop('checked',false);
				$('#divifcheck1').fadeIn(1300);
				$('#anotherchoice1').fadeIn(1300);
				$('#select_1-2').val('0');
				$('#select_2-2').val('0');
				$('#select_3-2').val('0');
				$('#select_1-2').formSelect();
				$('#select_2-2').formSelect();
				$('#select_3-2').formSelect();
				$('#div_select_2-2').hide();
				$('#div_select_3-2').hide();
				$('#submit-2').hide();
			});
		});

		$('#ifcheck1').change(function(){
			var student_id = $(this).val();
			var append = ' ';
			$.ajax({
				url: '{{ url('Ajax/getCourseInterest') }}',
  				method: 'get',
  				data: {
  						id: student_id,
  				},
  				success: function(data) {
  					// console.log(data);
  					// append += '<table class="centered"><thead><tr><th>In courses</th><th>Interested</th></tr></thead><tbody><tr><td>' + data.class + '</td><td>' + data.interest + '</td></tr></tbody></table>';
  					append += '<blockquote><p>Phone: ' + data.student_phone  + '</p>';
  					append += '<p>Email: ' + data.student_email + '</p></blockquote>';
  					$('#selectStudent').html(" ");
  					$('#selectStudent').append(append);
  					$('#interest').fadeIn();
  				},
			});

		});
	@for($a = 1; $a <= 2 ; $a++)
		$('#select_1-'+{{$a}}).change(function(){
			$('#div_select_2-'+{{$a}}).show();
			$('#div_select_3-'+{{$a}}).hide();
			var major_id = $(this).val();
 			var op=" ";
			//Ajax goes here
			$.ajax({
				url: '{{ url('Ajax/getCourses') }}',
				method: 'get',
				data: { 
						id: major_id,
				},
				success: function(data) {
					op+='<option value="0" selected disabled>Courses</option>';
					for(var i=0;i<data.length;i++)
						op+='<option value="'+data[i].course_id+'">'+data[i].course_name+'</option>';
					$('#select_2-'+{{$a}}).html(" ");
					$('#select_2-'+{{$a}}).append(op);
					$('#select_2-'+{{$a}}).formSelect();
				},
			});
		});

		$('#select_2-'+{{$a}}).on('change',function(){
			$('#div_select_3-'+{{$a}}).show();
 			var op=" ";
			//Ajax goes here
			$.ajax({
				url: '{{ url('Ajax/getSchedules') }}',
				method: 'get',
				success: function(data) {
					//console.log(data);
					op+='<option value="0" selected disabled>Schedules</option>';
					for(var i=0;i<data.length;i++)
					{
						op+='<option value="'+data[i].schedule_id+'">' + data[i].schedule_name + '</option>';
					}
					$('#select_3-'+{{$a}}).html(" ");
					$('#select_3-'+{{$a}}).append(op);
					$('#select_3-'+{{$a}}).formSelect();
				},
			});
		});
		$('#select_3-'+{{$a}}).change(function(){
			$('#submit-'+{{$a}}).fadeIn();
		});
	@endfor

	function checkInterest(id)
	{
		var course_id = $('#select_2-1').val();
		var schedule_id = $('#select_3-1').val();
		var rt;
		// console.log(course_id,schedule_id);
		$.ajax({
			async: false,
			url: '{{ url('Ajax/CheckInterest') }}',
			method: 'get',
			data: {
					student_id: id,
					course_id: course_id,
					schedule_id: schedule_id
			},
			success: function(data)
			{
				console.log(data);
				if(data.count > 0)
				{
					toastr.error('This student is already studying<br>this course');
					rt = false;
				}else if(data.checkTime > 0){
					if(data.check > 0)
					{
						toastr.error('This student is busy on this<br>schedule');
						rt = false;
					}else if(data.checkInterest > 0){
						toastr.error('This student already has interest<br>on this class');
						rt = false;
					}
				}else if(data.checkInterest > 0){
						toastr.error('This student already has interest<br>on this class');
						rt = false;
				}else rt = true;
				// rt = false;
			}
		});
		return rt;
	}
</script>
		<!--function toAMPM(time)
		{
			var split = time.split(':');
			var h = split[0];
			var m = split[1];
			var AMPM = 'AM';
			h -= 0;
			if(h > 12)
			{
				h -= 12;
				AMPM = 'PM';
			}else if(h == 12)
			{
				AMPM = 'PM';
			}else if(h == 24)
			{
				h -= 12;
				AMPM = 'AM';
			}
			var res = h + ':' + m + ' ' + AMPM;
			return res;
		}

	</script>-->
@endsection