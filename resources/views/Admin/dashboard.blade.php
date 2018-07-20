@extends('Admin.master')

@section('title')
    Admin Dashboard
@endsection

@section('css')
  <link href="{{asset('css/login/style.min.css')}}" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <style>
        #img {
            height: 100%;
        }
        #img img {
            width: 100%;
            height: 100%;
        }
        input {
            text-align: center;
        }
        ::-webkit-input-placeholder {
           text-align: center;
        }

        :-moz-placeholder { /* Firefox 18- */
           text-align: center;  
        }

        ::-moz-placeholder {  /* Firefox 19+ */
           text-align: center;  
        }

        :-ms-input-placeholder {  
           text-align: center; 
        }
        .ui-datepicker-calendar {
            display: none;
        }
        .form-control {
            width:auto;
            display:inline-block;
        }
        #body * {
            animation: fadeIn 0.5s forwards;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 100;
            }
        }
        table tbody td:hover{background:rgba(0,0,0,.08);}
        table.dataTable.no-footer {
          border-bottom: 0;
        }
    </style>
@endsection

@section('content')
<!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-circle-09 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">{{trans('lang.statistic_sale')}}</p>
                                <h4 class="card-title">{{count($sales)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> {{trans('lang.statistic_upd')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-cloud-upload-94 text-success"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">{{trans('lang.statistic_std')}}</p>
                                <h4 class="card-title">{{$students}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> {{trans('lang.statistic_upd')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-backpack text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">{{trans('lang.statistic_cls')}}</p>
                                <h4 class="card-title">{{count($classes)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> {{trans('lang.statistic_upd')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-chart text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">{{trans('lang.statistic_cls_opened')}}</p>
                                <h4 class="card-title" id="open_this_month"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> {{trans('lang.statistic_upd')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4" >
            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title">{{trans('lang.class_stats')}}</h4>
                    <p class="card-category">{{trans('lang.all_classes')}} {{count($classes)}}</p>
                </div>
                <div class="card-body ">
                    <div class="ct-chart ct-square">   
                        @if(count($classes) == 0)
                            <div id="img">
                                <img src="{{asset('images/nodata.gif')}}"/>
                            </div>
                        @else
                        <canvas id="chartPreferences" height="300%"></canvas>
                        @endif          
                        
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-clock-o"></i> {{trans('lang.class_stats_footer')}} 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title">{{trans('lang.sale_stats')}}</h4>
                    <p class="card-category">{{trans('lang.sale_stats_cate')}}</p>
                </div>
                <div class="card-body ">
                    <div class="ct-chart ct-major-tenth">
                        @if(count($sales) == 0)
                        <div align="center" id="img">
                            <img src="{{asset('images/nodata.gif')}}"/>
                        </div>
                        @else
                        <canvas id="chartActivity" height="130%"></canvas>
                        @endif
                    </div>
                </div>
                <div class="card-footer ">
                    <div class="legend">
                        <!-- <i class="fa fa-circle text-info"></i> Number of Students -->
                    </div>
                    <hr>
                    <div class="stats">
                        <i class="fa fa-check"></i> {{trans('lang.sale_stats_footer')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title" align="center">{{trans('lang.detail_stats')}}</h4>
                        <div class="form-group" align="center">
                            <label>{{trans('lang.month')}}</label>
                            <select class="form-control" id="month">
                                @for($i=1; $i <= 12; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <input class="yearselect form-control" id="year">
                            <label>{{trans('lang.year')}}</label>
                            <button type="button" class="btn btn-light" style="display:block;margin: 3px auto" id="viewstats">{{trans('lang.view_stats')}}</button>
                        </div>
                </div>
                <div class="card-body " id="body">
                    
                </div>
                <div class="card-footer ">

                </div>
            </div>
        </div>
    </div>
                    
                    
<input type="hidden" name="_token" value="{{csrf_token()}}">
@endsection

@section('js')
  <script src="{{asset('js/year-select.js')}}"></script>
  <script src="{{asset('js/Chart.bundle.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
  <script src="{{asset('js/pageloader.js')}}"></script>
@endsection

@section('js2')
    <script type="text/javascript">

        $(document).ready(function() {
            $('.yearselect').yearselect();
            var year = new Date().getFullYear();
            var month = new Date().getMonth();

            $('#month').val(month+1);
            $('#year').val(year);

            var m = $('#month').val();
            var y = $('#year').val();
                
            $.ajax({
                url: '{{ url('Ajax/ViewStats') }}',
                method: 'get',
                data: {
                        m: m,
                        y: y,
                },
                success: function(data){
                    // console.log(data.length);
                    $('#open_this_month').html(data.length);
                }
            });
            @if(count($classes) > 0)
                // var dataPreferences = {
                // series: [
                //     [25, 30, 20, 25]
                // ]};

                // var optionsPreferences = {
                //     donut: true,
                //     donutWidth: 40,
                //     startAngle: 0,
                //     total: 100,
                //     showLabel: false,
                //     axisX: {
                //         showGrid: false
                //     }
                // };

                var open_classes = 0;
                var close_classes = 0;
                var total_classes = {{count($classes)}};
                // //console.log(total_classes);

                @foreach($classes as $class)
                    @if($class->check == 0) close_classes++;
                    @else open_classes++;
                    @endif
                @endforeach

                // var open_percent = open_classes / total_classes * 100;
                // var close_percent = 100 - open_percent;
                // //console.log(open_classes,close_classes);

                // Chartist.Pie('#chartPreferences', dataPreferences, optionsPreferences);

                // if(open_classes == 0) var labels = ['', close_classes];
                // else if(close_classes == 0) var labels = [open_classes, ''];
                // else var labels = [open_classes, close_classes];
                

                // Chartist.Pie('#chartPreferences', {
                //     labels: labels,
                //     series: [open_percent, close_percent]
                // });
                var ctx = $('#chartPreferences');
                var config = {
                  type: 'pie',
                  data: {
                        datasets: [{
                        data: [open_classes,close_classes],
                         backgroundColor: [
                          'rgb(29,199,234)',
                          'rgb(255,74,85)'
                      ],
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                        '{{trans('lang.pie_open')}}',
                        '{{trans('lang.pie_close')}}',
                    ],
                      },
                      options: {
                        responsive: true
                      }
                    };
                var myPieChart = new Chart(ctx, config);

            @endif
            // ------------------------------------------------------------------------------------ //
            @if(count($sales) > 0)
                @foreach($sales as $sale)
                                var count_{{$sale->sale_id}};
                                var id = {{$sale->sale_id}};
                                var token = $("input[name='_token']").val();
                                $.ajax({
                                    async: false,
                                    url: '{{ url('Ajax/SaleStat') }}',
                                    method: 'get',
                                    data: {
                                            id: id,
                                            _token: token
                                    },
                                    success: function(data) {
                                        count_{{$sale->sale_id}} = data;
                                    },
                                });
                         @endforeach
                // var data = {
                //     labels: [@foreach($sales as $sale) '{{$sale->sale_name}}' , @endforeach],
                //     series: [[@foreach($sales as $sale) count_{{$sale->sale_id}} , @endforeach]]
                // };

                // var options = {
                //     seriesBarDistance: 2,
                //     axisY: {
                //         onlyInteger: true,
                //     },
                //     axisX: {
                //         showGrid: false,
                //     },
                //     height: "245px"

                // };

                // var responsiveOptions = [
                //     ['screen and (max-width: 640px)', {
                //         seriesBarDistance: 5,
                //         axisX: {
                //             labelInterpolationFnc: function(value) {
                //                 return value[0];
                //             }
                //         }
                //     }]
                // ];

                // var chartActivity = Chartist.Bar('#chartActivity', data, options, responsiveOptions);
                var ctx2 = $('#chartActivity');
                var config2 = {
                    type: 'bar',
                    data: {
                        labels: [@foreach($sales as $sale) '{{$sale->sale_name}}' , @endforeach],
                        datasets: [
                            {
                                label: '{{trans('lang.chart_stat')}}',
                                backgroundColor: "rgb(29,199,234)",
                                borderColor: "#fff",
                                borderWidth: 1,
                                data: [
                                   @foreach($sales as $sale) count_{{$sale->sale_id}} , @endforeach
                                ]
                            }]
                        },

                        options: {
                            scales: {
                              yAxes: [{
                                ticks:{
                                  min : 0,
                                  stepSize : 1,
                                  fontColor : "#000",
                                  fontSize : 14
                                },
                              }],
                              xAxes: [{
                                ticks:{
                                  fontColor : "#000",
                                  fontSize : 14
                                },
                                gridLines:{
                                  color: "#fff",
                                  lineWidth:2
                                }
                              }]
                            },
                            legend: false,
                            responsive: true,
                        }
                };
                var myBarChart = new Chart(ctx2, config2);
            @endif

            $('#viewstats').click(function(){
                var m = $('#month').val();
                var y = $('#year').val();
                var token = $("input[name='_token']").val();
                var append = ' ';
                // console.log(m,y);
                $.ajax({
                    url: '{{ url('Ajax/ViewStats') }}',
                    method: 'get',
                    data: {
                            m: m,
                            y: y,
                            _token: token
                    },
                    success: function(data){
                        // console.log(data);
                        if(data.length > 0)
                        {
                            append += '<table id="mytable" class="table table-hover"><thead><tr><th>{{trans('lang.db_class_name')}}</th><th>{{trans('lang.db_class_startdate')}}</th><th>{{trans('lang.db_class_students')}}</th><th class="not-export-col"></th></tr></thead><tbody>';
                            for(var i=0;i<data.length;i++)
                            {
                                append += '<tr><td>' + data[i].class_name + '</td><td>' + data[i].class_startdate + '</td><td>' + data[i].count + '</td><td><a target=_blank href="Classes/classDetail-' + data[i].class_id + '.html" class="btn">{{trans('lang.db_class_detail')}}</a></td></tr>';
                            }
                            append += '</tbody></table>';
                            $('#body').html(' ');
                            $('#body').append(append);
                            var date = new Date();
                            var monthNames = ["{{trans('lang.month_1')}}", "{{trans('lang.month_2')}}", "{{trans('lang.month_3')}}", "{{trans('lang.month_4')}}", "{{trans('lang.month_5')}}", "{{trans('lang.month_6')}}",
                              "{{trans('lang.month_7')}}", "{{trans('lang.month_8')}}", "{{trans('lang.month_9')}}", "{{trans('lang.month_10')}}", "{{trans('lang.month_11')}}", "{{trans('lang.month_12')}}"
                            ];
                            var month = monthNames[date.getMonth()];
                            $('#mytable').dataTable({
                                dom: "<'row'<'col-md-12'l>>Bfrtip",
                                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "@if(Session('locale') == 'en') All @else Tất cả @endif"] ], 
                                buttons: [
                                    {
                                        extend: 'excel',
                                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                                        title: '{{trans('lang.db_excel_title')}}' + month,
                                        exportOptions: {
                                          columns: ':visible:not(.not-export-col)'
                                        }
                                    },
                                    {
                                        extend: 'print',
                                        text: '<i class="fa fa-print"></i> Print',
                                        title: '',
                                        exportOptions: {
                                          columns: ':visible:not(.not-export-col)'
                                        },
                                        customize: function ( win ) {
                                            $(win.document.body)
                                            .prepend(
                                                '<div align="center"><img src="{{asset('images/bachkhoa.png')}}" width="400px"/><h4>{{trans('lang.db_excel_title')}} ' + month + '</h4></div>'
                                            );
                                        }
                                    },
                                ],
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
                            $('select').addClass('form-control');
                            $('input').addClass('form-control');
                        }else 
                        {
                            append += '<div class="container" align="center" id="mytable"><img src="{{asset('images/nodata.gif')}}"/></div>';
                            $('#body').html(' ');
                            $('#body').append(append);
                        }                       
                    },
                });
            });
                dashboard = {
                        showNotification: function() {
                            var color = Math.floor((Math.random() * 4) + 1);
                            @if(Session('locale') == 'vn') var message = 'Chào mừng bạn đến <b>Admin Dashboard</b> - Hệ thống quản lý tuyển sinh <b>BKACAD</b>.';
                            @else var message = 'Welcome to <b>Admin Dashboard</b> - BKACAD International Certificate Classes Management.';
                            @endif
                            $.notify({
                                icon: "nc-icon nc-app",
                                message: message

                            }, {
                                type: type[color],
                                timer: 3000,
                                placement: {
                                    from: 'top',
                                    align: 'right'
                                }
                            });
                        }
                    }
                   dashboard.showNotification();

        });

    </script>
@endsection