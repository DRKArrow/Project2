@extends('Admin.master')

@section('title')
  {{trans('lang.major_manage')}}
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{asset('css/floatingbutton.css')}}">
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
    .btn.btn-info[disabled], .btn.btn-danger[disabled] {
        background-color: grey;
        border-color: grey;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover" id="card-master">
            <div class="card-header ">
                <h4 class="card-title">{{trans('lang.major_list')}}</h4>
                <p class="card-category">{{trans('lang.major_cate')}}</p>
            </div>
            <div id="notice" style="position: absolute;top:5px;right:5px;color: grey;font-style: italic;">
                <p>{{trans('lang3.notice_major')}}</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table  id="mytable" align="center" class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>{{trans('lang.major_name')}}</th>
                        <th>{{trans('lang.action')}}</th>
                    </thead>
                    <tbody>
                        @foreach($majors as $major)
                        <tr>
                            <td>{{$major->major_id}}</td>
                            <td>{{$major->major_name}}</td>
                            <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#seeDetail-{{$major->major_id}}">{{trans('lang.seedetail')}}</a> 
                              <a href="#" class="btn btn-info" data-toggle="modal" @if($major->major_name == 'Programming' || $major->major_name == 'Networking') disabled data-target="#" @else data-target="#edit-{{$major->major_id}}" @endif>{{trans('lang.edit')}}</a>
                              <a href="#" class="btn btn-danger" data-toggle="modal" @if($major->major_name == 'Programming' || $major->major_name == 'Networking') disabled data-target="#" @else data-target="#deletemajor-{{$major->major_id}}" @endif >{{trans('lang.delete')}}</a></td>
                              <!-- Modal -->
                              <div class="modal fade" id="deletemajor-{{$major->major_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.major_delete_confirm')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.major_delete_name')}}{{$major->major_name}}</p>
                                      <p>{{trans('lang.major_delete_conf')}}</p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                                      <a href="deleteMajor-{{$major->major_id}}" onclick="return checkDelete({{$major->major_id}})"><button type="button" class="btn btn-danger">{{trans('lang.delete_btn')}}</button></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Modal 2 -->
                              <div class="modal fade" id="seeDetail-{{$major->major_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.seedetail')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.major_delete_name')}}{{$major->major_name}}</p>
                                      <p class="form-group">{{trans('lang.major_detail')}} ({{count($major->course)}}): 
                                        <select class="form-control">
                                          @if(count($major->course) == 0)
                                              <option>{{trans('lang.no_course')}}</option>
                                          @else
                                            @foreach($major->course as $course)
                                              <option>{{$course}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Modal 3  -->
                              <div class="modal fade" id="edit-{{$major->major_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form method="post" action="{{route('editMajor')}}">
                                      @csrf
                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">{{trans('lang.edit')}}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        <p>{{trans('lang.major_delete_name')}}{{$major->major_name}}</p>
                                        <p class="form-group">
                                            <input type="hidden" name="txtId" value="{{$major->major_id}}">
                                            <input type="text" name="txtName" class="form-control" value="{{$major->major_name}}" placeholder="{{trans('lang.major_name')}}">
                                          </p>
                                      </div>
                                       <!-- Modal footer -->
                                      <div class="modal-footer">
                                        <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                                        <button type="button" class="btn btn-info">{{trans('lang.edit')}}</button>
                                      </div>
                                   </form>
                                  </div>
                                </div>
                              </div>
                              <!-- End Modal -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div> 


  <div class="fixed-action-btn">
    <a class="btn-floating" data-toggle="modal" data-target="#addMajor"><i class="nc-icon nc-simple-add"></i></a>
  </div>
  			<div class="modal fade" id="addMajor">
		        <div class="modal-dialog">
		          <div class="modal-content">

		            <!-- Modal Header -->
		            <div class="modal-header">
		              <h4 class="modal-title">{{trans('lang.major_add')}}</h4>
		              <button type="button" class="close" data-dismiss="modal">&times;</button>
		            </div>

		            <!-- Modal body -->
		            <div class="modal-body">
		              <form method="post" action="addMajorProcess" id="addForm">
		              	@csrf
		              	<div class="row">
		                    <div class="col-md-12">
		                        <div class="form-group">
		                            <label>{{trans('lang.major_add_name')}}</label>
		                            <input type="text" class="form-control" name="txtName" placeholder="{{trans('lang.major_placeholder')}}" required>
		                        </div>
		                    </div>
	                    </div>
		              </form>
		            </div>

		            <!-- Modal footer -->
		            <div class="modal-footer">
		              <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
		              <button type="submit" class="btn btn-danger" onclick="checkAdd()">{{trans('lang.major_add_btn')}}</button>
		            </div>

		          </div>
		        </div>
 		    </div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
@endsection

@section('js')
  <script type="text/javascript" src="{{asset('js/core/validate.min.js')}}"></script>
@endsection

@section('js2')
  <script type="text/javascript">
  $(document).ready(function(){
     $( "table thead tr th:last-child" ).addClass('disabled-sorting').addClass('text-right');
     $("table tbody tr td:last-child").addClass('text-right').addClass('sorting_1');
     $('#mytable').DataTable({
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
        function checkAdd()
        {
          $('#addForm').validate({
            rules: {
              txtName: {
                required: true,
                maxlength: 30,
              }
            },
            messages: {
              txtName: {
                 required: '{{trans('lang3.validate_no_empty')}}',
                 maxlength: '{{trans('lang3.validate_maxlength_30')}}',
              }
            },
            errorElement: 'em',
          });
          $('#addForm').submit();
        } 

        function checkDelete(id)
        {
          // console.log(id);
          var token = $('input[name=_token]').val();
          var rt;
          $.ajax({
            async: false,
            url: '{{ url('Ajax/CheckDeleteMajor') }}',
            method: 'get',
            data: {
              id: id,
              _token: token
            },
            success: function(data){
              if(data > 0){
                toastr.error('{{trans('lang3.validate_delete_major')}}');
                rt = false;
              }else {
                rt = true;
              }
            }
          });
          return rt;
        }
  </script>
@endsection

