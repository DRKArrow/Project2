@extends('Admin.master')

@section('title')
  {{trans('lang.interest_manage')}}
@endsection

@section('css')
  <style>
    table tbody td:hover{background:rgba(0,0,0,.08);}
    table.dataTable.no-footer {
      border-bottom: 0;
    }
    #card-master {
      padding:20px;
      animation: load 0.5s;
    }
    #card-master * {
      animation: loadcontent 0.6s;
    }
    @keyframes load {
      0% {
        height: 0%;
      }
      100% {
        height: 93%;
      }
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
	<div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover" id="card-master">
            <div class="card-header ">
                <h4 class="card-title">{{trans('lang.interest_list')}}</h4>
                <p class="card-category">{{trans('lang.interest_cate')}}</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table  id="mytable" align="center" class="table table-hover">
                    <thead>
                        <th>{{trans('lang.interest_class')}}</th>
                        <th>{{trans('lang.interest_students')}}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($interests as $interest)
            							<tr>
            								<td>{{$interest->class_name}}</td>
            								<td>{{$interest->count}}</td>
            								<td><a href="{{route('interestDetail',['id' => $interest->interest])}}" class="btn btn-primary">{{trans('lang.seedetail')}}</a> <a href="addClass-{{$interest->interest}}" class="btn btn-success">{{trans('lang.interest_create_class_btn')}}</a></td>
            							</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div> 
@endsection

@section('js2')
	<script>
		$(document).ready(function(){
     $( "table thead tr th:last-child" ).addClass('disabled-sorting').addClass('text-right');
     $("table tbody tr td:last-child").addClass('text-right').addClass('sorting_1');
			$('#mytable').dataTable({
  				order: [1, 'desc'],
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
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   2,
        } ],
			});
		});
	</script>
@endsection