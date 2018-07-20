
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{asset('images/login.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/materialize/flag-icon.min.css')}}" type="text/css" rel="stylesheet">

    @yield('css')
    <style>
        @media (max-width: 991px) {
            .fixed-plugin {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="{{route('Admindashboard')}}" class="simple-text logo-mini">
                        <img src="{{asset('images/login.png')}}" height="25px" />
                    </a>
                    <a href="{{route('Admindashboard')}}" class="simple-text logo-normal">
                        BKACAD
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item @if(Request::is('Admin/dashboard')) active @endif">
                        <a class="nav-link" href="{{route('Admindashboard')}}">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item  @if(Request::is('Admin/Sales/*')) active @endif">
                        <a class="nav-link" href="{{route('salesList')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>{{trans('lang.manage_sales')}}</p>
                        </a>
                    </li>
                    <li class="nav-item  @if(Request::is('Admin/Majors/*')) active @endif">
                        <a class="nav-link" href="{{route('majorsList')}}">
                            <i class="nc-icon nc-single-copy-04"></i>
                            <p>{{trans('lang.manage_majors')}}</p>
                        </a>
                    </li>
					<li class="nav-item  @if(Request::is('Admin/Courses/*')) active @endif">
                        <a class="nav-link" href="{{route('coursesList')}}">
                            <i class="nc-icon nc-notes"></i>
                            <p>{{trans('lang.manage_courses')}}</p>
                        </a>
                    </li>
					<li class="nav-item  @if(Request::is('Admin/Schedules/*')) active @endif">
                        <a class="nav-link" href="{{route('schedulesList')}}">
                            <i class="nc-icon nc-watch-time"></i>
                            <p>{{trans('lang.manage_schedules')}}</p>
                        </a>
                    </li>
					<li class="nav-item  @if(Request::is('Admin/Classes/*')) active @endif">
                        <a class="nav-link" href="{{route('classesList')}}">
                            <i class="nc-icon nc-backpack"></i>
                            <p>{{trans('lang.manage_classes')}}</p>
                        </a>
                    </li>
                    <li class="nav-item  @if(Request::is('Admin/Interests/*')) active @endif">
                        <a class="nav-link" href="{{route('interestsList')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>{{trans('lang.manage_interests')}}</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                    <p class="navbar-brand"> Dashboard </p>
                    <button href="#" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification" id="count_notification"></span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu" id="count">
                                    @if($count>0)
                                        <a class="dropdown-item" href="{{route('interestsList')}}"> {{$count}} {{trans('lang.ajax_class_interest')}}</a>
                                    @endif
                                    @if(count($count2)>0)
                                        <a class="dropdown-item" href="{{route('classesList')}}"> {{count($count2)}} {{trans('lang.ajax_class_opened')}}</a>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon flag-icon" id="flagSelect"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{route('changeLanguage',['language' => 'en'])}}" class="dropdown-item">
                                          <i class="flag-icon flag-icon-gb"></i>  {{trans('lang.en-select')}}</a>
                                      </li>
                                      <li>
                                        <a href="{{route('changeLanguage',['language' => 'vn'])}}" class="dropdown-item">
                                          <i class="flag-icon flag-icon-vn"></i>  {{trans('lang.vn-select')}}</a>
                                      </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    <span class="no-icon">{{session('admin_name')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('adminLogout')}}">
                                    <span class="no-icon">{{trans('lang.log-out')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid" style="min-height: 87.5vh">
                	@yield('content')
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-plugin" style="position: fixed">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> {{trans('lang.sidebar_style')}}</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>{{trans('lang.background_image')}}</p>
                        <label class="switch-image1">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>{{trans('lang.sidebar_mini')}}</p>
                        <label class="switch-mini1">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>{{trans('lang.fixed_navbar')}}</p>
                        <label class="switch-nav1">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>{{trans('lang.background_color')}}</p>
                        <label class="switch-color">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line" id="selectColor">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <p>{{trans('lang.colors')}}</p>
                        <div class="pull-right">
                            <span class="badge filter badge-black" data-color="black"></span>
                            <span class="badge filter badge-azure" data-color="azure"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-orange" data-color="orange"></span>
                            <span class="badge filter badge-red" data-color="red"></span>
                            <span class="badge filter badge-purple" data-color="purple"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">{{trans('lang.sidebar_images')}}</li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-1.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-2.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-3.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-4.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-5.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-6.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-7.jpg')}}" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="{{asset('images/sidebar-8.jpg')}}" alt="" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
 <input type="hidden" name="_token" value="{{csrf_token()}}">
</body>
<!--   Core JS Files   -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('js/plugins/bootstrap-switch.js')}}"></script>
<!--  Chartist Plugin  -->
<script src="{{asset('js/plugins/chartist.min.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('js/plugins/bootstrap-notify.js')}}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{asset('js/light-bootstrap-dashboard.js?v=2.0.1')}}" type="text/javascript"></script>
<script src="{{asset('js/dashboardad.js')}}"></script>
<script src="{{asset('js/jsEach/dashboard.js')}}"></script>
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>


	@yield('js')
	@yield('js2')
	<script>
        
        @if(Session::has('message'))
            var type="{{Session::get('alert-type','info')}}"

            switch(type){
                case 'info':
                     toastr.info("{{ Session::get('message') }}");
                     break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
        $(document).ready(function(){
            @if(Session::get('locale') =='vn') 
                $('#flagSelect').addClass('flag-icon-vn');
            @elseif(Session::get('locale')=='en')
                $('#flagSelect').addClass('flag-icon-gb');
            @endif
            $('select').addClass('form-control');
            $('input').addClass('form-control');
            //---------------------------------
            var count = $('#count a').length;
            if(count == 0)
            {
                $('#count').append('<a href="#" class="dropdown-item">No notification</a>');
            }
            $('#count_notification').html(count);
        });
    </script>
</html>