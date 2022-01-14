@extends('master.layout.index' ,['title' => _i('Home')])

@section('content')
    <!-- page start-->
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{_i('Dashboard')}}</h4>
    </div>
    <!--breadcrumbs end -->
    <div class="row">



        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $msg }}
                        <br>


                    </h3>
                </div>



            </div>
        </div>

    </div>


@endsection
