<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, intitial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{asset('css/materialize.css')}}">
  	<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Barlow" rel="stylesheet">
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
	<title>Sale Panel</title>
@yield('css')
	<style>
		header, main, footer, body {
	      padding-left: 300px;
	    }

	    @media only screen and (max-width : 992px) {
	      header, main, footer, body {
	        padding-left: 0;
	      }
	    }
	    #logo {
	    	max-width: 100%;
		  	height: auto;
		  	max-height: 4vh;
	    }
	    .cover {
		   object-fit: cover;
		   width: 100%;
		   height: 300px;
		}
		@media (max-width: 1024px) {
			.cover {
				object-fit: cover;
			   width: 100%;
			   height: 150px;
			}
		}
	</style>
</head>
<body style="background: rgb(247,247,247)">

	@include('Sale.nav')
	<div id="content" style="width: 95%;margin: auto">
		<div class="section">
		@yield('content')
	</div>
	@yield('modal')
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/materialize.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/metisMenu.js')}}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	@yield('js')
	@yield('js2')
	<script>
			$(document).ready(function(){
	    $('.fixed-action-btn').floatingActionButton();
	  });
			 $(document).ready(function(){
    $('select').formSelect();
  });
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
	$(document).ready(function() {
		$('.collapsible').collapsible();
	    $('input.textcounter').characterCounter();
	  });
	</script>

	
</body>
</html>