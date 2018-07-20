@extends('Admin.master')

@section('title')
  {{trans('lang.class_manage')}}
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{asset('css/floatingbutton.css')}}">
  <style>
    table tbody td:hover{background:rgba(0,0,0,.08);}
    table.dataTable.no-footer {
      border-bottom: 0;
    }
    #div_select_2, #div_select_3 {
      display:none;
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
    .btn.btn-success[disabled], .btn.btn-danger[disabled] {
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
                <h4 class="card-title">{{trans('lang.class_list')}}</h4>
                <p class="card-category">{{trans('lang.class_cate')}}</p>
            </div>
            <div id="notice" style="position: absolute;top:5px;right:5px;color: grey;font-style: italic;">
                <p>{{trans('lang3.notice_class')}}</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table  id="mytable" align="center" class="table table-hover">
                    <thead>
                        <th>{{trans('lang.class_name')}}</th>
                        <th>{{trans('lang.class_startdate')}}</th>
                        <th>{{trans('lang.class_students')}}</th>
                        <th>{{trans('lang.action')}}</th>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <tr @if($class->check == 0) style="background:rgba(0, 255, 0, 0.15)" @endif>
                            <td>{{$class->class_name}}</td>
                            <td>@if($class->check != 0) {{$class->class_startdate}} @else {{trans('lang.not_open')}} @endif</td>
                            <td>{{$class->count}}</td>
                            <td><a href="{{route('classDetail',['id' => $class->class_id])}}" target="_blank" class="btn btn-primary">{{trans('lang.seedetail')}}</a> <a href="OpenClass-{{$class->class_id}}" onclick="return checkOpen({{$class->class_id}})"><button class="btn btn-success" @if($class->check != 0) disabled @endif >{{trans('lang.class_open_btn')}}</button></a> <a href="deleteclass-{{$class->class_id}}" data-toggle="modal" data-target="#deleteclass-{{$class->class_id}}"><button class="btn btn-danger" @if($class->check !=0) disabled @endif>{{trans('lang.delete')}}</button></a></td>
                            <div class="modal fade" id="deleteclass-{{$class->class_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.class_delete_confirm')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.class_delete_name')}}{{$class->class_name}}</p>
                                      <p>{{trans('lang.class_delete_conf')}}</p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                                      <a href="deleteClass-{{$class->class_id}}" onclick="return check({{$class->class_id}})"><button type="button" class="btn btn-danger">{{trans('lang.delete_btn')}}</button></a>
                                    </div>

                                  </div>
                                </div>
                              </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div> 


  <div class="fixed-action-btn">
    <a class="btn-floating" data-toggle="modal" data-target="#addclass"><i class="nc-icon nc-simple-add"></i></a>
  </div>
        <div class="modal fade" id="addclass">
            <div class="modal-dialog">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">{{trans('lang.class_add')}}</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <form method="post" action="{{route('addClassProcess')}}" id="addForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select id="select_1" class="form-control">
                                  <option selected disabled>{{trans('lang.class_add_major')}}</option>
                                  @foreach($majors as $major)
                                    <option value="{{$major->major_id}}">{{$major->major_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="div_select_2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select id="select_2" class="form-control" name="ddlCourse" required>
                                  <option value="0" selected disabled>{{trans('lang.ajax_course')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="div_select_3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select id="select_3" class="form-control" name="ddlSchedule" required>
                                  <option value="0" selected disabled>{{trans('lang.ajax_schedule')}}</option>
                                </select>
                              </div>
                        </div>
                    </div>
                  </form>
                </div>


                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                  <button type="submit" class="btn btn-danger" onclick="checkAdd()">{{trans('lang.class_add_btn')}}</button>
                </div>

              </div>
            </div>
        </div>

@endsection

@section('js2')
  <script type="text/javascript">
  $(document).ready(function(){

     $( "table thead tr th:last-child" ).addClass('disabled-sorting').addClass('text-right');
     $("table tbody tr td:last-child").addClass('text-right').addClass('sorting_1');
     $('#mytable').DataTable({
      order: [2, 'desc'],
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
            targets:   3,
        } ],
      bAutoWidth: false , 
      aoColumns : [
        { sWidth: '30%' },
        { sWidth: '20%' },
        { sWidth: '10%' },
        { sWidth: '40%' },
      ]
     });
  });

  $('#select_1').change(function(){
      $('#div_select_2').show();
      $('#div_select_3').hide();
      var major_id = $(this).val();
      var token = $("input[name='_token']").val();
      var op=" ";
      //Ajax goes here
      $.ajax({
        url: '{{ url('Ajax/getCourses') }}',
        method: 'get',
        data: { 
            id: major_id,
            _token: token
        },
        success: function(data) {
          op+='<option value="0" selected disabled>{{trans('lang.ajax_course')}}</option>';
          for(var i=0;i<data.length;i++)
            op+='<option value="'+data[i].course_id+'">'+data[i].course_name+'</option>';
          $('#select_2').html(" ");
          $('#select_2').append(op);
          $('#select_3').html(" ");
        },
      });
    });

  $('#select_2').change(function(){
      $('#div_select_3').show();
      var token = $("input[name='_token']").val();
      var op=" ";
      //Ajax goes here
      $.ajax({
        url: '{{ url('Ajax/getSchedules') }}',
        method: 'get',
        data: { 
            _token: token
        },
        success: function(data) {
          //console.log(data);
          op+='<option value="0" selected disabled>{{trans('lang.ajax_schedule')}}</option>';
          for(var i=0;i<data.length;i++)
          {
            op+='<option value="'+data[i].schedule_id+'">' + data[i].schedule_name + '</option>';
          }
          $('#select_3').html(" ");
          $('#select_3').append(op);
        },
      });
    });
    function check(id)
    {
      var rt;
      //console.log(id);
      $.ajax({
        async: false,
        url: '{{ url('Ajax/CheckClass') }}',
        method: 'get',
        data: {
                id: id,
        },
        success: function(data)
        {
          // console.log(data);
          if(data > 0)
          {
            var std;
            @if(Session('locale') == 'vn')
               std = ' học viên';
            @else
              if(data == 1) std = ' student';
              else std = ' students'; 
            @endif
            toastr.error('{{trans('lang.ajax_error_checkstd')}}' + data + std);
            rt = false;
          }else 
          {
            rt = true;
          }
        }
      });
      return rt;
    }
    function checkOpen(id)
    {
      var rt;
      // console.log(id);
      $.ajax({
        async: false,
        url: '{{ url('Ajax/CheckOpenClass') }}',
        method: 'get',
        data: {
                id: id,
        },
        success: function(data)
        {
          // console.log(data);
          if(data < 13)
          {
            toastr.info('{{trans('lang.ajax_info_checkopen')}}' + data + ')');
            rt = false;
          }else 
          {
            rt = true;
          }
        }
      });
      return true;
    }
    function checkAdd()
    {
      var select_course = $('#select_2').val();
      var select_schedule = $('#select_3').val();
      var check = 0;
      if(select_course === null) check++;
      if(select_schedule === null) check++;
      console.log(check);
      if(check == 2) {
        toastr.info('{{trans('lang3.validate_add_class')}}');
      }else if(check == 1) {
        toastr.info('{{trans('lang3.validate_add_class2')}}');
      }else {
        $('#addForm').submit();
      }

    }
  </script>
@endsection
