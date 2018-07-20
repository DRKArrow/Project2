@extends('Admin.master')

@section('title')
  {{trans('lang.sale_manage')}}
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{asset('css/floatingbutton.css')}}">
  <style>
    table tbody td:hover{background:rgba(0,0,0,.08);}
    table.dataTable tfoot th {
      border-top: 0;
    }
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
      <div class="card" id="card-master">
            <div class="card-header ">
                <h4 class="card-title">{{trans('lang.sale_list')}}</h4>
                <p class="card-category">{{trans('lang.sale_cate')}}</p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table id="mytable" align="center" class="table table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>{{trans('lang.sale_name')}}</th>
                        <th>EMAIL</th>
                        <th>{{trans('lang.sale_phone')}}</th>
                        <th>{{trans('lang.sale_student')}}</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td><img src="{{asset($sale->sale_avatar)}}" style="width: 64px;height: 64px;border-radius: 50%"></td>
                            <td>{{$sale->sale_name}}</td>
                            <td>{{$sale->sale_email}}</td>
                            <td>{{$sale->sale_phone}}</td>
                            <td>{{$sale->students}}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div> 


  <div class="fixed-action-btn">
    <a href="{{route('addSale')}}" class="btn-floating"><i class="nc-icon nc-simple-add"></i></a>
  </div>
        
@endsection

@section('js2')
  <script type="text/javascript">
  $( "table thead tr th:first-child" ).addClass('disabled-sorting');
     $("table tbody tr td:first-child").addClass('text-center');
  $(document).ready(function(){
    $('#mytable').DataTable({
      order: [4, 'desc'],
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
            targets:   0,
        },
        {
            className: 'control',
            orderable: false,
            targets:   5,
        } ],
    });
  });
         
  </script>
@endsection

