@extends('Sale.newmaster')

@section('title')
	{{trans('lang2.tt_student_interest')}}
@endsection
@section('css')
	<style>
		#div_select_2-1, #div_select_3-1, #div_select_2-2, #div_select_3-2, #submit-1, #submit-2 {
			display:none;
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
	<div class="card-panel" style="position: relative">
		<div class="col s12">
			<div class="row margin">
				<div class="col s5 offset-s1 right-align" id="divselect1">
					<label id="selection1">
						<input type="checkbox" id="select1">
						<label for="select1">{{trans('lang2.interest_select1')}}</label>
					</label>
				</div>
				<div class="col" id="or">
					<span id="selectionor">{{trans('lang2.interest_selector')}}</span>
				</div>
				<div class="col s5 left-align" id="divselect2">
					<label id="selection2">
						<input type="checkbox" id="select2">
						<label for="select2">{{trans('lang2.interest_select2')}}</label>
					</label>
				</div>				
			</div>
			<div class="row margin anotherchoice" id="anotherchoice1">
				<div class="col s12 right-align">
					<label>
						<input type="checkbox" id="choice1">
						<label for="choice1">{{trans('lang2.interest_select2')}}</label>
					</label>
				</div>
			</div>
			<div class="row margin anotherchoice" id="anotherchoice2">
				<div class="col s12 right-align">
					<label>
						<input type="checkbox" id="choice2">
						<label for="choice2">{{trans('lang2.interest_select1')}}</label>
					</label>
				</div>
			</div>
			
				<div class="row margin" id="divifcheck1">
					<form method="post" action="{{route('addInterest')}}">
						@csrf
						<div class="container">
							<select id="ifcheck1" name="ddlStudent">
								<option value="default" selected disabled>{{trans('lang2.interest_select1')}}</option>
								@foreach($students as $student)
									<option value="{{$student->student_id}}">{{$student->student_name}}</option>
								@endforeach
							</select>
						<div id="selectStudent" class="row margin"></div>
						</div>
						<div class="container">
							<div class="row margin" id="interest">
								<div class="input-field col s12 center-align">
									<h5>{{trans('lang2.interest_student_interesting')}}</h5>
								    <select id="select_1-1" class="">
								    	<option value="0" selected disabled>{{trans('lang2.interest_major')}}</option>
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
								<button class="btn" type="submit" onclick="return checkInterest($('#ifcheck1').val())">{{trans('lang2.interest_submit')}}</button>
							</div>
						</div>
					</form>
				</div>
				<div class="container">
					<div class="row margin" id="divifcheck2">
						<form method="post" action="{{route('addInterestNew')}}" accept-charset="UTF-8" class="col s12" id="addForm">
					 		@csrf
						  	<div class="row margin">
							    <div class="input-field col s12">
							      <input id="name" name="txtName" type="text" data-length="30" class="textcounter">
							      <label for="name" class="center-align"><i class="material-icons">person_outline</i> {{trans('lang2.student_name')}}</label>
							    </div>
							</div>
						  	<div class="row margin">
							    <div class="input-field col s12">
							      <input id="phone" name="txtPhone" type="text" data-length="15" class="textcounter">
							      <label for="phone"><i class="material-icons">local_phone</i> {{trans('lang2.student_phone')}}</label>
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
									<h5>{{trans('lang2.interest_student_interesting')}}</h5>
								    <select id="select_1-2">
								    	<option value="0" selected disabled>{{trans('lang2.interest_major')}}</option>
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
								<button class="btn" type="submit" onclick="return checkInterest2()">{{trans('lang2.interest_submit')}}</button>
							</div>
						</form>
					</div>
				</div>
			<p style="position: absolute;left: 5px;bottom: -13px;font-style: italic;display:none" class="grey-text" id="notice">{{trans('lang3.notice')}}</p>
		 </div>
	</div>
</div>
@endsection

@section('js')
  <script type="text/javascript" src="{{asset('js/core/validate.min.js')}}"></script>
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
			$('#notice').fadeOut();
			$.when($('#anotherchoice1').fadeOut()).done(function(){
				$('#choice1').prop('checked',false);
				$('#divifcheck2').fadeIn(1300);
				$('#anotherchoice2').fadeIn(1300);
				$('#ifcheck1 option[value=default]').prop('selected',true);
				$('#ifcheck1').material_select();
				$('#selectStudent').html(" ");
				$('#interest').fadeOut();
				$('#select_1-1').val('0');
				$('#select_2-1').val('0');
				$('#select_3-1').val('0');
				$('#select_1-1').material_select();
				$('#select_2-1').material_select();
				$('#select_3-1').material_select();
				$('#div_select_2-1').hide();
				$('#div_select_3-1').hide();
				$('#submit-1').hide();
			});
		});

		$('#choice2').click(function(){
			$('#divifcheck2').fadeOut();
			$('#notice').fadeOut();
			$.when($('#anotherchoice2').fadeOut()).done(function(){
				$('#choice2').prop('checked',false);
				$('#divifcheck1').fadeIn(1300);
				$('#anotherchoice1').fadeIn(1300);
				$('#select_1-2').val('0');
				$('#select_2-2').val('0');
				$('#select_3-2').val('0');
				$('#select_1-2').material_select();
				$('#select_2-2').material_select();
				$('#select_3-2').material_select();
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
  					append += '<blockquote><p>{{trans('lang2.student_phone')}}: ' + data.student_phone  + '</p>';
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
			$('#notice').fadeOut();
			$('#submit-'+{{$a}}).fadeOut();
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
					op+='<option value="0" selected disabled>{{trans('lang2.interest_course')}}</option>';
					for(var i=0;i<data.length;i++)
						op+='<option value="'+data[i].course_id+'">'+data[i].course_name+'</option>';
					$('#select_2-'+{{$a}}).html(" ");
					$('#select_2-'+{{$a}}).append(op);
					$('#select_2-'+{{$a}}).material_select();
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
					op+='<option value="0" selected disabled>{{trans('lang2.interest_schedule')}}</option>';
					for(var i=0;i<data.length;i++)
					{
						op+='<option value="'+data[i].schedule_id+'">' + data[i].schedule_name + '</option>';
					}
					$('#select_3-'+{{$a}}).html(" ");
					$('#select_3-'+{{$a}}).append(op);
					$('#select_3-'+{{$a}}).material_select();
				},
			});
		});
		$('#select_3-'+{{$a}}).change(function(){
			$('#submit-'+{{$a}}).fadeIn();
			$('#notice').fadeIn();
		});
	@endfor

	$(document).ready(function(){
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[a-zÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹế\s]+$/i.test(value);
		}); 
		jQuery.validator.addMethod("noSpace", function(value, element) { 
          return value.indexOf(" ") < 0 && value != ""; 
         });
		$('#addForm').validate({
			rules: {
				txtName: {
					required: true,
					lettersonly: true,
				},
				txtEmail: {
					required: true,
					noSpace: true,
					email: true,
				},
				txtPhone: {
					required: true,
					noSpace: true,
					digits: true,
					minlength: 9,
					maxlength: 15,
				},
			},
			messages: {
				txtName: {
					required: '{{trans('lang3.validate_no_empty')}}',
					lettersonly: '{{trans('lang3.validate_only_letters')}}',
				},
				txtEmail: {
					required: '{{trans('lang3.validate_no_empty')}}',
					noSpace: '{{trans('lang3.validate_no_space')}}',
					email: '{{trans('lang3.validate_email')}}',
				},
				txtPhone: {
					required: '{{trans('lang3.validate_no_empty')}}',
					noSpace: '{{trans('lang3.validate_no_space')}}',
					digits: '{{trans('lang3.validate_digits')}}',
					minlength: '{{trans('lang3.validate_minlength_9')}}',
					maxlength: '{{trans('lang3.validate_maxlength_15')}}',
				},
			},
			errorElement: 'em',
		});
	});

	function checkInterest(id)
	{
		var course_id = $('#select_2-1').val();
		var schedule_id = $('#select_3-1').val();
		var rt;
		if(schedule_id === null)
		{
			toastr.info('{{trans('lang3.validate_add_class2')}}');
			rt = false;
		}else {
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
					// console.log(data);
					if(data.count > 0)
					{
						@if(session('locale') == 'vn') var error = 'Học viên đang theo học<br>khóa học này';
						@else var error = 'This student is already studying<br>this course';
						@endif
						toastr.error(error);
						rt = false;
					}else if(data.checkTime > 0){
						if(data.check > 0)
						{
							@if(session('locale') == 'vn') var error = 'Học viên có lớp học vào<br>lịch này';
							@else var error = 'This student is busy on this<br>schedule';
							@endif
							toastr.error(error);
							rt = false;
						}else if(data.checkInterest > 0){
							@if(session('locale') == 'vn') var error = 'Học viên đã quan tâm đến<br>lớp này';
							@else var error = 'This student already has interest<br>on this class';
							@endif
							toastr.error(error);
							rt = false;
						}else rt = true;
					}else if(data.checkInterest > 0){
							@if(session('locale') == 'vn') var error = 'Học viên đã quan tâm đến<br>lớp này';
							@else var error = 'This student already has interest<br>on this class';
							@endif
							toastr.error(error);
							rt = false;
					}else rt = true;
					// rt = false;
				}
			});
		}
		return rt;
	}
	function checkInterest2()
	{
		var schedule_id = $('#select_3-2').val();
		var rt = true;
		// console.log(schedule_id);
		if(schedule_id === null)
		{
			toastr.info('{{trans('lang3.validate_add_class2')}}');
			rt = false;
		}
		return rt;
	}
</script>
@endsection