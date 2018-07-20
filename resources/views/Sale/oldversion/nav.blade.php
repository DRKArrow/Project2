
 <div class="container"><a href="#" data-target="nav-mobile" class="top-nav sidenav-trigger waves-effect waves-light circle hide-on-large-only"><i class="material-icons">menu</i></a></div>
<ul id="nav-mobile" class="sidenav sidenav-fixed">
        <li class="logo center-align"><a href="{{route('dashboard')}}" class="brand-logo"><img src="{{asset('images/bachkhoa.png')}}" id="logo"></a></li>
        <div class="divider"></div>
        <ul class="collapsible collapsible-accordion">
          <li class="bold center-align"><a class="collapsible-header waves-effect waves-teal">{{session('sale_name')}}</a>
            <div class="collapsible-body">
                <ul>
                  <li><a href="{{route('saleLogout')}}">Logout</a></li>
                </ul>
              </div>
          </li>
        </ul>
        <div class="divider"></div>
        <li class="no-padding @if(Request::is('Sale/dashboard')) active @endif">
          <ul>
            <li class="bold"><a class="collapsible-header waves-effect waves-teal" href="{{route('dashboard')}}">Dashboard</a>
            </li>   
          </ul>
        </li>
        <li class="no-padding @if(Request::is('Sale/Student/*')) active @endif">
          <ul class="collapsible collapsible-accordion">
            <li class="bold @if(Request::is('Sale/Student/*')) active @endif"><a class="collapsible-header waves-effect waves-teal">Students Management</a>
              <div class="collapsible-body">
                  <ul>
                    <li class="@if(Request::is('Sale/Student/addStudent')) active @endif"><a href="{{route('addStudent')}}">Add Student</a></li>
                    <li class="@if(Request::is('Sale/Student/studentInterest')) active @endif"><a href="{{route('studentInterest')}}">Student Interesting</a></li>
                  </ul>
                </div>
            </li>   
          </ul>
        </li>
        <li class="no-padding @if(Request::is('Sale/Class/classList*')) active @endif">
          <ul>
            <li class="bold"><a class="collapsible-header waves-effect waves-teal" href="{{route('classList')}}">Classes Management</a>
            </li>   
          </ul>
        </li>
      </ul>
   <!-- asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd --> 
  <!-- ul id="dropdown-user" class="user dropdown-content">
      <li><a href="#"><i class="fas fa-edit"></i>Infomation</a></li>
      <li><a href="{{route('saleLogout')}}"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
  </ul> -->
  @section('js')
    <script type="text/javascript">
        $(document).ready(function(){
        $('.sidenav').sidenav();
      });
         $('.dropdown-trigger').dropdown();
    </script>
  @endsection