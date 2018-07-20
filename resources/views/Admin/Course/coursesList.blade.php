@extends('Admin.master')

@section('title')
  {{trans('lang.course_manage')}}
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
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card strpied-tabled-with-hover" id="card-master">
            <div class="card-header ">
                <h4 class="card-title">{{trans('lang.course_list')}}</h4>
                <p class="card-category">{{trans('lang.course_cate')}}</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table  id="mytable" align="center" class="table table-hover">
                    <thead>
                        <th>{{trans('lang.course_name')}}</th>
                        <th>{{trans('lang.course_major')}}</th>
                        <th>{{trans('lang.action')}}</th>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{$course->course_name}}</td>
                            <td>{{$course->major_name}}</td>
                            <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#seeDetail-{{$course->course_id}}">{{trans('lang.seedetail')}}</a> <a href="#" class="btn btn-info" data-toggle="modal" data-target="#edit-{{$course->course_id}}">{{trans('lang.edit')}}</a>
                              <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteCourse-{{$course->course_id}}">{{trans('lang.delete')}}</a></td>
                              <!-- Modal -->
                              <div class="modal fade" id="deleteCourse-{{$course->course_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.course_delete_confirm')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.course_delete_name')}}{{$course->course_name}}</p>
                                      <p>{{trans('lang.course_delete_conf')}}</p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                                      <a href="deleteCourse-{{$course->course_id}}" onclick="return check({{$course->course_id}})"><button type="button" class="btn btn-danger">{{trans('lang.delete_btn')}}</button></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Modal 2 -->
                              <div class="modal fade" id="seeDetail-{{$course->course_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.seedetail')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.course_delete_name')}}{{$course->course_name}}</p>
                                      <p class="form-group">{{trans('lang.course_detail')}} ({{count($course->class)}}): 
                                        <select class="form-control">
                                          @if(count($course->class) == 0)
                                              <option>{{trans('lang.no_class')}}</option>
                                          @else
                                            @foreach($course->class as $class)
                                              <option>{{$class}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Modal 3 -->
                              <div class="modal fade" id="edit-{{$course->course_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form method="post" action="{{route('editCourse')}}" id="editForm-{{$course->course_id}}">
                                        @csrf
                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">{{trans('lang.edit')}}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        
                                          <p>{{trans('lang.course_delete_name')}}{{$course->course_name}}</p>
                                          <p class="form-group">
                                            <input type="hidden" name="txtId" value="{{$course->course_id}}">
                                            <input type="text" id="name-{{$course->course_id}}" name="txtName" class="form-control" value="{{$course->course_name}}" placeholder="{{trans('lang.course_name')}}" required>
                                            <p>{{trans('lang.course_edit_major')}}</p>
                                            <select name="ddlMajor">
                                              @foreach($majors as $major)
                                                <option value="{{$major->major_id}}" @if($course->major_id == $major->major_id) selected @endif>{{$major->major_name}}</option>
                                              @endforeach
                                            </select>
                                          </p>

                                      </div>
                                      <!-- Modal footer -->
                                      <div class="modal-footer">
                                        <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                                        <button type="submit" class="btn btn-info" onclick="return checkEdit({{$course->course_id}})">{{trans('lang.edit')}}</button>
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
    <a class="btn-floating" data-toggle="modal" data-target="#addCourse"><i class="nc-icon nc-simple-add"></i></a>
  </div>
        <div class="modal fade" id="addCourse">
            <div class="modal-dialog">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">{{trans('lang.course_add')}}</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <form method="post" action="addCourseProcess" id="addForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('lang.course_add_name')}}</label>
                                <input type="text" class="form-control" name="txtName" placeholder="{{trans('lang.course_placeholder')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('lang.course_add_major')}}</label>
                                <select class="form-control" name="ddlMajor" id="selectMajor">
                                  <option selected disabled>{{trans('lang.course_select_major')}}</option>
                                  @foreach($majors as $major)
                                    <option value="{{$major->major_id}}">{{$major->major_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                      </div>
                  </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                  <button type="submit" class="btn btn-danger" onclick="checkAdd()">{{trans('lang.course_add_btn')}}</button>
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
      jQuery.validator.addMethod("noSpace", function(value, element) { 
          return value.indexOf(" ") < 0 && value != ""; 
         });
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
      bAutoWidth: false , 
      aoColumns : [
        { sWidth: '30%' },
        { sWidth: '30%' },
        { sWidth: '40%' },
      ]
     });
     $('#addForm').validate({
            rules: {
              txtName: {
                required: true,
                noSpace: true,
                maxlength: 36,
              }
            },
            messages: {
              txtName: {
                 required: '{{trans('lang3.validate_no_empty')}}',
                 noSpace: '{{trans('lang3.validate_no_space')}}',
                 maxlength: '{{trans('lang3.validate_maxlength_36')}}',
              }
            },
            errorElement: 'em',
     });
  });
  function checkAdd()
  {
    var val = $('#selectMajor').val();
    // console.log(val);
    if(val === null){
      toastr.info('{{trans('lang3.validate_add_course')}}');
    }else {
      $('#addForm').submit();
    }
  }
  function check(id)
  {
    // console.log(id);
    var token = $('input[name=_token]').val();
    var rt;
    $.ajax({
      async: false,
      url: '{{ url('Ajax/CheckDeleteCourse') }}',
      method: 'get',
      data: {
        id: id,
        _token: token
      },
      success: function(data){
        if(data > 0){
          toastr.error('{{trans('lang3.validate_delete_course')}}');
          rt = false;
        }else {
          rt = true;
        }
      }
    });
    return rt;
  }
  function checkEdit(id)
  {
    // console.log(id);
    var token = $('input[name=_token]').val();
    var name = $('#name-'+id).val();
    // console.log(name);
    var rt;
    if(name.length == 0)
    {
      toastr.info('{{trans('lang3.edit_course_name')}}');
      rt = false;
    }else if(name.length > 36){
      toastr.info('{{trans('lang3.edit_course_name_maxlength')}}');
      rt = false;
    }else if(name.indexOf(' ') > -1)
    {
      toastr.info('{{trans('lang3.edit_course_name_no_space')}}');
      rt = false;
    }else rt = true;
    return rt;
  }
  </script> 
@endsection
