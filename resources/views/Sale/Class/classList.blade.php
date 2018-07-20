@extends('Sale.newmaster')

@section('title')
	{{$course_name}}
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
  <nav>
    <div class="nav-wrapper gradient-shadow gradient-45deg-amber-amber " style="padding-left:20px;z-index: 2">
      <div class="col s12">
        <a href="{{route('courseList',['id' => $id])}}" class="breadcrumb black-text">{{$major}}</a>
        <a class="breadcrumb">{{$course_name}}</a>
      </div>
    </div>
  </nav>
	<div class="section"></div>
  <div class="se-pre-con" id="preloader" style="display:none"></div>
  <div id="default">
		<div class="row">
			@foreach($classes as $class)
				<div class="col s12 m12 l12">
                  <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-200 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt">layers</i>
                        <p>{{$class->class_name}}</p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h6 class="">{{$class->student}} {{trans('lang2.db_student4')}}</h6>
                        <h5 class="no-margin"><a href="{{route('class_detail',['id' => $id,'id2' => $class->class_id])}}" class="white-text text-darken-1 btn waves-effect waves-light gradient-45deg-amber-amber btn-large gradient-shadow">{{trans('lang2.class_see_detail')}}</a></h5>
                        <h5 class="margin-5">@if($class->check == 1) {{trans('lang2.class_opened')}} @endif</h5>
                      </div>
                    </div>
                  </div>
                </div>
			@endforeach
		</div>
    <div class="center-align">{{$classes->links('pagination.pagination')}}</div>
  </div>
  <!-- Result -->
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
        prepend += '<i class="material-icons">search</i><input type="text" id="search" class="header-search-input z-depth-2" placeholder="{{trans('lang3.search_by_class')}}" /></div>';
        $('#nav-wrapper').prepend(prepend);
        $('#search').keyup(function(){
            var key = $(this).val();
            if(key != null)
            {
              $.when($('#default').hide()).done(function(){
                 $('#result').show();
              });
              $.ajax({
                  url: '{{ url('Ajax/SearchClass') }}',
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