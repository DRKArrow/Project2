@extends('Sale.newmaster')

@section('title')
	{{$major_name}}
@endsection

@section('css')
  <style>
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 1;
        background: url({{asset("images/preloader.gif")}}) center no-repeat #fff;
    }
  </style>
@endsection

@section('content')
<div class="container">
	<div class="section"></div>
  <div class="se-pre-con" id="preloader" style="display:none"></div>
    <!-- Default on load -->
    <div id="default">
  		<div class="row">
  			@foreach($courses as $course)
  				<div class="col s12 m12 l12">
                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                      <div class="padding-4">
                        <div class="col s7 m7">
                          <i class="material-icons background-round mt">layers</i>
                          <p>{{$course->course_name}}</p>
                        </div>
                        <div class="col s5 m5 right-align">
                          <h5 class="mb-0">{{$course->open}}</h5>
                          <p class="no-margin">{{trans('lang2.db_classopen')}}</p>
                          <h4 class="mb-4"><a href="{{route('classList',['id' => $course->major_id,'id2' => $course->course_id])}}" class="white-text text-darken-1 btn waves-effect waves-light gradient-45deg-amber-amber btn-large gradient-shadow">{{$course->all}} {{trans('lang2.db_classes2')}}</a></h4>
                        </div>
                      </div>
                    </div>
                  </div>
  			@endforeach
  		</div>
      <div class="center-align">{{$courses->links('pagination.pagination')}}</div>
    </div>
    <!-- Result when search -->
    <div id="result">
    </div>
    <!-- End -->
</div>
@endsection

@section('js2')
  <script>
    $(document).ready(function(){
        if(localStorage.getItem('navbar') == 'false')
        {
          var prepend = '<div class="header-search-wrapper hide-on-med-and-down">';
        }else {
          var prepend = '<div class="header-search-wrapper hide-on-med-and-down sideNav-lock">';
        }
        prepend += '<i class="material-icons">search</i><input type="text" id="search" class="header-search-input z-depth-2" placeholder="{{trans('lang3.search_by_course')}}" /></div>';
        $('#nav-wrapper').prepend(prepend);
        $('#search').keyup(function(){
            var key = $(this).val();
            if(key != '')
            {
              $.when($('#default').hide()).done(function(){
                 $('#result').show();
              });
              $.ajax({
                  url: '{{ url('Ajax/SearchCourse') }}',
                  method: 'get',
                  dataType: 'text',
                  data: {
                      key: key,
                  },
                  beforeSend: function()
                  {
                    $('#result').hide();
                    $('#preloader').show();
                  },
                  success: function(data)
                  {
                      $.when($('#preloader').fadeOut()).done(function(){  
                      $('#result').fadeIn();    
                      $('#result').html(data);
                    });
                  }
              });
            }else {
             $.when($('#result').hide()).done(function(){
                $('#preloader').show();
                  $.when($('#preloader').fadeOut()).done(function(){ 
                    $('#default').show(); 
                  }); 
              });
            }
        });
    });
  </script>
@endsection