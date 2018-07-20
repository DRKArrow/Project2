@extends('Admin.master')

@section('title')
  {{trans('lang.class_detail_manage')}}
@endsection

@section('css')
  <link href="{{asset('css/login/style.min.css')}}" type="text/css" rel="stylesheet" media="screen,projection">
	<link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
	<style>
		img {
			max-width: 100%;
			  height: auto;
			  max-height: 15vh;
		}
		.card {
			padding: 30px;
		}
		table tbody td:hover{background:rgba(0,0,0,.08);}
	    table.dataTable.no-footer {
	      border-bottom: 0;
	    }
	</style>
@endsection

@section('content')
	<!-- Start Page Loading -->
	  <div id="loader-wrapper">
	      <div id="loader"></div>        
	      <div class="loader-section section-left"></div>
	      <div class="loader-section section-right"></div>
	  </div>
  	<!-- End Page Loading -->

	<div class="card col-md-12">
		<div class="row">
			<div class="col-md-12" align="center">
				<img src="{{asset('images/bachkhoa.png')}}"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<h4 id="class">{{$class->class_name}}</h4>
			</div>
			<div class="col-md-7" align="right">
				<h4>{{trans('lang.class_detail_students')}}{{count($students)}}</h4>
			</div>
		</div>
		@if($class->check != 0)
			<div class="row">
				<div class="col-md-12" align="center">
					<h5>{{trans('lang.class_detail_startdate')}}{{date('d-m-Y',strtotime($class->class_startdate))}}</h5>
				</div>
			</div>
		@endif
		<div class="row">
			<div class="col-md-12 table-responsive">
				<table id="mytable" class="table table-hover">

					<thead>
						<tr>
							<th>{{trans('lang.class_detail_name')}}</th>
							<th>EMAIL</th>
							<th>{{trans('lang.class_detail_phone')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($students as $student)
							<tr>
								<td>{{$student->student_name}}</td>
								<td>{{$student->student_email}}</td>
								<td>{{$student->student_phone}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" id="startdate" value="{{date('d-m-Y',strtotime($class->class_startdate))}}">;
@endsection

@section('js')

	<script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
  	<script src="{{asset('js/pageloader.js')}}"></script>

@endsection

@section('js2')
	<script>
		$(document).ready(function(){
			$('#mytable').dataTable({
		        dom: "<'row'<'col-md-12'l>>Bfrtip",
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "@if(Session('locale') == 'en') All @else Tất cả @endif"] ],
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
			      },
		        buttons: [
		        	{
		        		extend: 'excel',
		        		text: '<i class="fa fa-file-excel-o"></i> Excel',
		        		title: $('#class').text(),
		        	},
		            {
		            	extend: 'print',
		            	text: '<i class="fa fa-print"></i> Print',
		            	title: '',
		            	customize: function ( win ) {
	                    	$(win.document.body)
	                        .prepend(
	                            '<div align="center"><img src="{{asset('images/bachkhoa.png')}}" width="400px"/><h4>' + $('#class').text() + '</h4> <h5> @if($class->check != 0) {{trans('lang.class_detail_startdate')}}' + $('#startdate').val() + ' @else {{trans('lang.class_detail_notopen')}} @endif </h5> </div><hr>'
                        	);
	                    }
		            },
		        ]
		    });
		});
	</script>
@endsection