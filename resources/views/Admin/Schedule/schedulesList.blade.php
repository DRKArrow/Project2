@extends('Admin.master')

@section('title')
  {{trans('lang.schedule_manage')}}
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
                <h4 class="card-title">{{trans('lang.schedule_list')}}</h4>
                <p class="card-category">{{trans('lang.schedule_cate')}}</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table  id="mytable" align="center" class="table table-hover">
                    <thead>
                      <tr>
                        <th>{{trans('lang.schedule_name')}}</th>
                        <th>{{trans('lang.schedule_starttime')}}</th>
                        <th>{{trans('lang.schedule_endtime')}}</th>
                        <th>{{trans('lang.action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>{{$schedule->schedule_name}}</td>
                            <td>{{date('h:i A',strtotime($schedule->schedule_start))}}</td>
                            <td>{{date('h:i A',strtotime($schedule->schedule_end))}}</td>
                            <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#seeDetail-{{$schedule->schedule_id}}">{{trans('lang.seedetail')}}</a>
                              
                              <a href="deleteschedule-{{$schedule->schedule_id}}" class="btn btn-danger" data-toggle="modal" data-target="#deleteschedule-{{$schedule->schedule_id}}">{{trans('lang.delete')}}</a></td>
                              <!-- Modal -->
                              <div class="modal fade" id="deleteschedule-{{$schedule->schedule_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.schedule_delete_confirm')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.schedule_delete_name')}}{{$schedule->schedule_name}}</p>
                                      <p>{{trans('lang.schedule_delete_conf')}}</p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                                      <a href="deleteSchedule-{{$schedule->schedule_id}}"><button type="button" class="btn btn-danger">{{trans('lang.delete_btn')}}</button></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Modal 2 -->
                              <div class="modal fade" id="seeDetail-{{$schedule->schedule_id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('lang.seedetail')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <p>{{trans('lang.schedule_delete_name')}}{{$schedule->schedule_name}}</p>
                                      <p class="form-group">{{trans('lang.schedule_detail')}} ({{count($schedule->class)}}): 
                                        <select class="form-control">
                                          @if(count($schedule->class) == 0)
                                              <option>{{trans('lang.no_class')}}</option>
                                          @else
                                            @foreach($schedule->class as $class)
                                              <option>{{$class}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                      </p>
                                    </div>
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
    <a class="btn-floating" data-toggle="modal" data-target="#addschedule"><i class="nc-icon nc-simple-add"></i></a>
  </div>
        <div class="modal fade" id="addschedule">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">{{trans('lang.schedule_add')}}</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <form method="post" action="addScheduleProcess" id="addForm">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="container form-inline">
                          <div class="col-md-4">
                              <select name="date_select_one" class="form-control" id="date_select_one">
                                <option disabled selected value="null">-------</option>
                                <option value="2">{{trans('lang.monday')}}</option>
                                <option value="3">{{trans('lang.tuesday')}}</option>
                                <option value="4">{{trans('lang.wednesday')}}</option>
                                <option value="5">{{trans('lang.thursday')}}</option>
                                <option value="6">{{trans('lang.friday')}}</option>
                                <option value="7">{{trans('lang.saturday')}}</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <select name="date_select_two" class="form-control" id="date_select_two">
                                <option disabled selected value="null">-------</option>
                                <option value="2">{{trans('lang.monday')}}</option>
                                <option value="3">{{trans('lang.tuesday')}}</option>
                                <option value="4">{{trans('lang.wednesday')}}</option>
                                <option value="5">{{trans('lang.thursday')}}</option>
                                <option value="6">{{trans('lang.friday')}}</option>
                                <option value="7">{{trans('lang.saturday')}}</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <select name="date_select_three" class="form-control" id="date_select_three">
                                <option disabled selected value="null">-------</option>
                                <option value="2">{{trans('lang.monday')}}</option>
                                <option value="3">{{trans('lang.tuesday')}}</option>
                                <option value="4">{{trans('lang.wednesday')}}</option>
                                <option value="5">{{trans('lang.thursday')}}</option>
                                <option value="6">{{trans('lang.friday')}}</option>
                                <option value="7">{{trans('lang.saturday')}}</option>
                              </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>{{trans('lang.time_start')}}</label>
                          <input name="txtTimeStart" class="form-control time_pick" id="time_start" type="text">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>{{trans('lang.time_end')}}</label>
                          <input name="txtTimeEnd" class="form-control time_pick" id="time_end" type="text">
                        </div>
                      </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn" data-dismiss="modal">{{trans('lang.close_btn')}}</button>
                  <button type="submit" class="btn btn-danger" onclick="return checkSubmit()">{{trans('lang.schedule_add_btn')}}</button>
                  </form>
                </div>

              </div>
            </div>
        </div>

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
            targets:   3,
        } ],
      bAutoWidth: false , 
      aoColumns : [
        { sWidth: '30%' },
        { sWidth: '20%' },
        { sWidth: '20%' },
        { sWidth: '30%' },
      ]
     });
  });

  $('#addForm').validate({
      rules: {
        txtTimeStart: {
            required: true,
        },
        txtTimeEnd: {
            required: true,
        }
      },
      messages: {
        txtTimeStart: {
            required: '{{trans('lang3.validate_no_empty')}}',
        },
        txtTimeEnd: {
            required: '{{trans('lang3.validate_no_empty')}}',
        }
      }
  });

  $('select[name*="date_select"]').change(function(){
    // start by setting everything to enabled
    $('select[name*="date_select"] option').attr('disabled',false);
    if($('#ddlNumberDay').change(function(){
       $('select[name*="date_select"] option').attr('disabled',false);
      }));
    // loop each select and set the selected value to disabled in all other selects
    $('select[name*="date_select"]').each(function(){
        var $this = $(this);
        $('select[name*="date_select"]').not($this).find('option').each(function(){
           if($(this).attr('value') == $this.val())
               $(this).attr('disabled',true);
          });
      });
    
  }); 

  function minFromMidnight(tm){
     var ampm= tm.substr(-2);
     var clk = tm.substr(0, 5);
     var m  = parseInt(clk.match(/\d+$/)[0], 10);
     var h  = parseInt(clk.match(/^\d+/)[0], 10);
     if(h == 12 && ampm == 'AM')
     {
      h = 00;
     }else if(h == 12 && ampm == 'PM')
     {
      h = 12;
     }else
     {
       h += (ampm.match(/pm/i))? 12: 0;
     }
     return h*60+m;
   } 

   $('.time_pick').change(function () {
    var thisvalue = $(this).val();
    var output;
    var hour;
    var ampm;
    if(thisvalue > 12 && thisvalue < 25)
    {
        hour = thisvalue - 12;
        ampm = 'PM';
        output = hour + ':00 ' + ampm;
    }else if(thisvalue < 12)
    {
      hour = thisvalue;
      ampm = 'AM';
      output = hour + ':00 ' + ampm;
    }else if(thisvalue == 12)
    {
      hour = thisvalue;
      ampm = 'PM';
      output = hour + ':00 ' + ampm;
    }else
    {
      output = '';
    }
    if(output.length == 7)
    {
      output = '0' + output;
    }
      $(this).val(output);
  });


   function checkSubmit(){
    
    var date1 = $('#date_select_one').val();
    var date2 = $('#date_select_two').val();
    var date3 = $('#date_select_three').val();
    var check = 0;
    var rt = 0;
    if(date1 === null || date1 == 'null') check++;
    if(date2 === null || date2 == 'null') check++;
    if(date3 === null || date3 == 'null') check++;
    if(check > 0)
    {
      toastr.info('{{trans('lang3.validate_select_date')}}');
      rt = 0;
    }else {
      rt++;
    }
     var startTime = $('#time_start').val();
    var endTime = $('#time_end').val();
    var st = minFromMidnight(startTime);
     var et = minFromMidnight(endTime);
    if(st>=et){
      @if(Session('locale') == 'en') var message = 'End time must be greater than<br> start time';
      @else var message = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu';
      @endif
      toastr.error(message);
      rt = 0;
    }else {
      rt++;
    }
    if(rt==2)
    {
      return true;
    }else {
      return false;
    }
  };
  </script>
@endsection
