@extends('Sale.newmaster')

@section('title')
  Sale Dashboard
@endsection

@section('content')
<!-- Start Page Loading -->
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->
          <!--start container-->
          <div class="container">
            <!--card stats start-->
            <div id="card-stats">
              <div class="row">
                <div class="col s12 m6 l6">
                  <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">layers</i>
                        <p>{{trans('lang2.db_classes')}}</p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0">{{$open}}</h5>
                        <p class="no-margin">{{trans('lang2.db_classopen')}}</p>
                        <p>{{$all}} {{trans('lang2.db_classes2')}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l6">
                  <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">perm_identity</i>
                        <p>{{trans('lang2.db_student2')}}</p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0">{{$student_by}}</h5>
                        <p class="no-margin">{{trans('lang2.db_youradd')}}</p>
                        <p>{{$student_all}} {{trans('lang2.db_student3')}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--card stats end-->
              <!-- //////////////////////////////////////////////////////////////////////////// -->
            </div>
            <!--end container-->
        </section>
@endsection