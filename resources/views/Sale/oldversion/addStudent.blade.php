@extends('Sale.master')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<style>
		body {
			font-size: 1.1rem;
		}
	    table tbody td:hover{background:rgba(0,0,0,.02);}
	    table tbody tr:hover {background:rgba(0,0,0,.03);}
	    table thead th, table tfoot th {color: rgba(0,0,0,0.4); font-family: 'monoscope';font-size:0.9rem;}
	    table.dataTable thead th {
	      border-bottom: 0.5px solid rgba(0,0,0,0.4);
	    }
	    table.dataTable tfoot th {
	      border-top: 0.5px solid rgba(0,0,0,0.4);
	    }
	    table.dataTable.no-footer {
	      border-bottom: 0;
	    }
	    #cardtext {
			font-family: 'Barlow';
			opacity: 0;
			animation: blurFadeInOut 3s ease-in-out forwards;
		}
		#tablecard {
			padding:30px;
	    	border-radius: 2px;
		}
		#tablecard * {
			-webkit-animation: loadcontent 0.5s;
			-o-animation: loadcontent 0.5s;
			animation: loadcontent 0.5s;
		}
	    @keyframes loadcontent {
	      0%, 30% {
	        opacity: 0;
	      }
	      100% {
	        opacity: 100;
	      }
	    }
	    
 	</style>
@endsection
@section('content')
<div class="section"></div>
	<div class="row">
    	<img src="{{asset('images/class.jpg')}}" class="cover" />
	</div>
	<div class="card" id="tablecard">
		<table class="table hover" id="mytable">
			<thead>
				<tr>
					<th>NAME</th>
					<th>PHONE</th>
					<th>EMAIL</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($students as $student)
					<tr>
						<td>{{$student->student_name}}</td>
						<td>{{$student->student_phone}}</td>
						<td>{{$student->student_email}}</td>
						<td><a rel="tooltip" title="Remove" class="btn btn-flat waves-effect waves-light btn modal-trigger" href="#delete-{{$student->student_id}}">
                                <i class="fa fa-times"></i>
                            </a></td>
                            
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>NAME</th>
					<th>PHONE</th>
					<th>EMAIL</th>
					<th></th>
				</tr>
			</tfoot>
		</table>		
	</div>
</div>


		@foreach($students as $student)
		<div id="delete-{{$student->student_id}}" class="modal">
			<div class="modal-content">
			  <h4>Delete confirmation</h4>
			  <p>Do you really want to delete this student?</p>
			  <p>Student name: {{$student->student_name}}</p>
			</div>
			<div class="modal-footer">
			  <a href="deleteStudent-{{$student->student_id}}" class="modal-close waves-effect waves-green btn-flat" onclick="return check({{$student->student_id}})">Agree</a>
			</div>
		</div>
		@endforeach


		<div class="fixed-action-btn">
		  <a class="btn-floating btn-large blue modal-trigger" href="#modal1">
		    <i class="large material-icons">add</i>
		  </a>
		</div>


<div id="modal1" class="modal">
	<div class="modal-content">
	    <div class="col s12">
			<form method="post" action="{{route('addStudentProcess')}}" accept-charset="UTF-8" class="login-form">
		 		@csrf
			  	<div class="row margin">
				    <div class="input-field col s10 offset-s1">
				      <input id="name" name="txtName" type="text" data-length="30" class="textcounter">
				      <label for="name" class="center-align"><i class="material-icons">person_outline</i> Name</label>
				    </div>
				</div>
			  	<div class="row margin">
				    <div class="input-field col s10 offset-s1">
				      <input id="phone" name="txtPhone" type="text" data-length="15" class="textcounter">
				      <label for="phone"><i class="material-icons">local_phone</i> Phone</label>
				    </div>
				</div>
				<div class="row margin">
				    <div class="input-field col s10 offset-s1">
				      <input id="email" name="txtEmail" type="email">
				      <label for="email"><i class="material-icons">email</i> Email</label>
				    </div>
				</div>
				<div class="row margin center-align">
					<button type="submit" class="btn blue waves-effect waves-light">Add Student</button>
				</div>
			</form>
		</div>
    </div>
@endsection

@section('js2')
	<script>
		$(document).ready(function(){
			$('#mytable').dataTable();
		});
		 $(document).ready(function(){
		    $('.modal').modal();
		});
		function check(id)
		{
			var rt;
			//console.log(id);
			$.ajax({
				async: false,
				url: '{{ url('Ajax/CheckStudentSale') }}',
				method: 'get',
				data: {
						id: id
				},
				success: function(data)
				{
					// console.log(data);
					if(data > 0)
					{
						var cls;
						if(data == 1) cls = ' class';
						else cls = ' classes'
						toastr.error('This student is already studying in ' + data + cls);
						rt = false;
					}else rt = true
				}
			});
			return rt;
		}
	</script>
@endsection