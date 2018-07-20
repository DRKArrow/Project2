@extends('Admin.master')

@section('title')
  {{trans('lang.interest_manage')}}
@endsection

@section('css')
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
	<div class="card col-md-12">
		<div class="row">
			<div class="col-md-12" align="center">
				<img src="{{asset('images/bachkhoa.png')}}"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<h4 id="class">{{$interest->class_name}}</h4>
			</div>
			<div class="col-md-7" align="right">
				<h4>{{trans('lang.class_detail_students')}}{{count($students)}}</h4>
			</div>
		</div>
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
@endsection

@section('js2')
	<script>
		$(document).ready(function(){
			$('#mytable').dataTable({
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
		    });
		});
	</script>
@endsection