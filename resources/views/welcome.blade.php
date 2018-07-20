<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{asset('images/login.png')}}">
        <title>BKACAD</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            .no-js #loader { display: none;  }
            .js #loader { display: block; position: absolute; left: 100px; top: 0; }
            .se-pre-con {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url({{asset("images/preloader.gif")}}) center no-repeat #fff;
            }
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                margin: 115px;
            }

            .m-b-md {
                margin-bottom: 15px;
            }
            .row img {
                margin: 40px;
            }
        </style>
    </head>
    <body>
        <div class="se-pre-con"></div>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <img src="{{asset('images/bachkhoa.png')}}" height="150px" />
                </div>

                <div class="links">
                    <a href="{{route('adminLogin')}}">Admin</a>
                    <a href="{{route('saleLogin')}}">Sale</a>
                </div>
                <div class="row">
                    <a href="{{route('adminLogin')}}"><img src="{{asset('images/Admin.png')}}"></a>
                    <a href="{{route('saleLogin')}}"><img src="{{asset('images/user.png')}}"></a>
                </div>
            </div>
        </div>

        <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
        <script>
            $(window).load(function() {
                // Animate loader off screen
                $(".se-pre-con").delay(1000).fadeOut("slow");;
            });
        </script>
    </body>
</html>
