@extends('Sale.newmaster')

@section('title')
	{{trans('lang2.tt_student_manage')}}
@endsection

@section('css')
	<style>
		body {
			font-family: Roboto;
		}
	</style>
@endsection

@section('content')
	<div class="section"></div>
	<div class="container">
		<div class="row">
	    	<img src="{{asset('images/student.jpg')}}" class="cover" />
		</div>
		<div class="card-panel">
			<table class="highlight" id="mytable">
				<thead>
					<tr>
						<th>{{trans('lang.class_detail_name')}}</th>
						<th>{{trans('lang.class_detail_phone')}}</th>
						<th>EMAIL</th>
					</tr>
				</thead>
				<tbody>
					@foreach($students as $student)
						<tr>
							<td>{{$student->student_name}}</td>
							<td>{{$student->student_phone}}</td>
							<td>{{$student->student_email}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>		
		</div>
	</div>


		<div class="fixed-action-btn">
          <a class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow modal-trigger" href="#addModal">
            <i class="material-icons">add</i>
          </a>
        </div>

        <div id="addModal" class="modal">
	        <div class="modal-content">
				<form method="post" action="{{route('addStudentProcess')}}" accept-charset="UTF-8" class="col s12" id="addForm">
			 		@csrf
				  	<div class="row">
					    <div class="input-field col s10 offset-s1">
					      <input id="name" name="txtName" type="text" data-length="30" class="textcounter" required>
					      <label for="name" class="center-align"><i class="material-icons">person_outline</i> {{trans('lang2.student_name')}}</label>
					    </div>
					</div>
				  	<div class="row">
					    <div class="input-field col s10 offset-s1">
					      <input id="phone" name="txtPhone" type="text" data-length="15" class="textcounter" required>
					      <label for="phone"><i class="material-icons">local_phone</i> {{trans('lang2.student_phone')}}</label>
					    </div>
					</div>
					<div class="row">
					    <div class="input-field col s10 offset-s1">
					      <input id="email" name="txtEmail" type="email" required>
					      <label for="email"><i class="material-icons">email</i> Email</label>
					    </div>
					</div>
					<div class="row center-align">
						<button type="submit" class="btn blue waves-effect waves-light">{{trans('lang2.student_add')}}</button>
					</div>
				</form>
		    </div>
	    </div>
@endsection

@section('js')
  <script type="text/javascript" src="{{asset('js/core/validate.min.js')}}"></script>
@endsection


@section('js2')
	<script>
		$(document).ready(function(){
			jQuery.validator.addMethod("lettersonly", function(value, element) {
				return this.optional(element) || /^[a-zÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹế\s]+$/i.test(value);
			}); 
			jQuery.validator.addMethod("noSpace", function(value, element) { 
	          return value.indexOf(" ") < 0 && value != ""; 
	         });
			$('#mytable').dataTable({
				language: {
		          "decimal":        "",
		          "emptyTable":     "{{trans('lang.dttb_emptyTable')}}",
		          "info":           "{{trans('lang.dttb_info')}}",
		          "infoEmpty":      "{{trans('lang.dttb_infoEmpty')}}",
		          "infoFiltered":   "{{trans('lang.dttb_infoFiltered')}}",
		          "infoPostFix":    "",
		          "thousands":      ",",
		          "lengthMenu":     "{{trans('lang.dttb_lengthMenu')}}",
		          "loadingRecords": "{{trans('lang.dttb_loadingRecords')}}",
		          "processing":     "{{trans('lang.dttb_processing')}}",
		          "search":         "{{trans('lang.dttb_search')}}",
		          "zeroRecords":    "{{trans('lang.dttb_zeroRecords')}}",
		          "paginate": {
		              "first":      "{{trans('lang.dttb_first')}}",
		              "last":       "{{trans('lang.dttb_last')}}",
		              "next":       "{{trans('lang.dttb_next')}}",
		              "previous":   "{{trans('lang.dttb_previous')}}"
		          }
		      }
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
	</script>
@endsection