@extends('Sale.newmaster')

@section('title')
	{{$course->course_name}}
@endsection

@section('content')
<div class="container">
  <div class="section"></div>
  <nav>
    <div class="nav-wrapper gradient-shadow gradient-45deg-amber-amber " style="padding-left:20px">
      <div class="col s12">
        <a href="{{route('courseList',['id' => $id])}}" class="breadcrumb black-text">{{$major}}</a>
        <a href="{{route('classList',['id' => $id,'id2' => $course->course_id])}}" class="breadcrumb black-text">{{$course->course_name}}</a>
        <a class="breadcrumb">{{$class->class_name}}</a>
      </div>
    </div>
  </nav>
	<div class="section"></div>
		<div class="row">
      <div class="col s12">
        <div class="card-panel">
    			<table class="highlight" id="mytable">
            <thead>
              <tr>
                <th>{{trans('lang2.detail_no')}}</th>
                <th>{{trans('lang2.detail_name')}}</th>
                <th>{{trans('lang2.detail_phone')}}</th>
                <th>EMAIL</th>
                <th>{{trans('lang2.detail_added')}}</th>
              </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                  <tr>
                    <td>{{$student->number}}</td>
                    <td>{{$student->student_name}}</td>
                    <td>{{$student->student_phone}}</td>
                    <td>{{$student->student_email}}</td>
                    <td>{{$student->sale_name}}</td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
		</div>
</div>

        <div class="fixed-action-btn">
          <a class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow modal-trigger" href="#addModal">
            <i class="material-icons">add</i>
          </a>
        </div>
        <div id="addModal" class="modal">
          <div class="modal-content">
            <div class="row margin">
              <div class="input-field col s4 offset-s4">
                <form method="post" action="{{route('addStudentIntoClass')}}" id="addStudent">
                  @csrf
                  <select name="ddlStudent" id="selectStudent">
                    <option disabled selected>{{trans('lang2.detail_std')}}</option>
                    @foreach($students_add as $student)
                      <option value="{{$student->student_id}}">{{$student->student_name}}</option>
                    @endforeach
                  </select>
                  <input type="hidden" name="class_id" value="{{$class->class_id}}">
                </form>
              </div>
            </div>
            <div class="row margin" id="table">
            </div>
            <div class="section"></div>
            <div class="row margin center-align">
              <button type="button" class="modal-close waves-effect waves-green btn" id="abc">{{trans('lang2.detail_add')}}</button>
            </div>
        </div>
      </div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
@endsection

@section('js2')
  <script>
      $(document).ready(function(){
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
      });

    
      $('#selectStudent').change(function(){
        var token = $("input[name='_token']").val();
        var student_id = $(this).val();
        var append = " ";
        //console.log(student_id);
        $.ajax({
          url: '{{ url('Ajax/getStudentName') }}',
          method: 'get',
          data: {
              id: student_id,
              _token: token
          },
          success: function(data) {
            //console.log(data[0].student_name);
            append += '<blockquote><p>{{trans('lang2.student_phone')}}: ' + data.student_phone  + '</p>';
            append += '<p>Email: ' + data.student_email + '</p></blockquote>';
            $('#table').html(" ");
            $('#table').append(append);
          },
        });
      });

      $('#abc').click(function(){
        var student_id = $('#selectStudent').val();
        var class_id = {{$class->class_id}};
        //console.log(id);
        $.ajax({
          url: '{{ url('Ajax/CheckStudent') }}',
          method: 'get',
          data: {
              _token: $('input[name=_token]').val(),
              student_id: student_id,
              class_id: class_id
          },
          success: function(data){
            console.log(data);
            if(data.count > 0)
            {
              @if(session('locale') == 'vn') var error = 'Học viên đang học lớp này!';
              @else var error = 'This student already in this<br>class!';
              @endif
              toastr.error(error);
            }else if(data.checkTime > 0)
            {
              if(data.check > 0)
              {
                @if(session('locale') == 'vn') var error = 'Học viên có lớp học vào<br>lịch này';
                @else var error = 'This student is busy on this<br>schedule';
                @endif
                toastr.error(error);
              }else
              {
                $('#addStudent').submit();
              }
            }else {
              $('#addStudent').submit();
            }
          },
        });
      });
  </script>
@endsection