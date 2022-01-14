@extends('master.layout.index' ,['title' => _i('Home')])

@section('content')
    <!-- page start-->
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{_i('Dashboard')}}</h4>
    </div>
    <!--breadcrumbs end -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body text-center">
                    <div class="counter-status dash3-counter">
                        <div class="counter-icon bg-primary text-primary">
                            <i class="si si-people text-white"></i>
                        </div>
                        <h5>{{ _i('Registered Users') }}</h5>
                        <h2 class="counter count">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body text-center">
                    <div class="counter-status dash3-counter">
                        <div class="counter-icon bg-info text-info">
                            <i class="si si-tag text-white"></i>
                        </div>
                        <h5>{{ _i('Projects') }}</h5>
                        <h2 class="counter count2">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body text-center">
                    <div class="counter-status dash3-counter">
                        <div class="counter-icon bg-success text-success">
                            <i class="si si-rocket text-white"></i>
                        </div>
                        <h5>{{ _i('Transactions') }}</h5>
                        <h2 class="counter count3">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body text-center">
                    <div class="counter-status dash3-counter">
                        <div class="counter-icon bg-danger text-danger">
                            <i class="si si-docs text-white"></i>
                        </div>
                        <h5>{{ _i('Complaints') }}</h5>
                        <h2 class="counter count4">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row state-overview">

        <div class="col-xl-3 col-lg-6 col-md-12 bg-white">
            @include("master.home.chart_status")
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            @include("master.home.chart_types")

        </div>
        <br>
        <div class="col-xl-6 col-lg-6 col-md-12">
            @include("master.home.chart_date")

        </div>
        <div class="col-xl-6 col-lg-6 col-md-12">
            @include("master.home.project.chart_date")

        </div>
        <div class="col-lg-3 col-sm-3 bg-white">
            @include("master.home.project.chart_status")
        </div>
    </div>

    <!-- page end-->
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script type="text/javascript">
            function countUp(count) {
                var div_by = 100,
                    speed = Math.round(count / div_by),
                    $display = $('.count'),
                    run_count = 1,
                    int_speed = 24;

                var int = setInterval(function() {
                    if (run_count < div_by) {
                        $display.text(speed * run_count);
                        run_count++;
                    } else if (parseInt($display.text()) < count) {
                        var curr_count = parseInt($display.text()) + 1;
                        $display.text(curr_count);
                    } else {
                        clearInterval(int);
                    }
                }, int_speed);
            }


            function countUp2(count) {
                var div_by = 100,
                    speed = Math.round(count / div_by),
                    $display = $('.count2'),
                    run_count = 1,
                    int_speed = 24;

                var int = setInterval(function() {
                    if (run_count < div_by) {
                        $display.text(speed * run_count);
                        run_count++;
                    } else if (parseInt($display.text()) < count) {
                        var curr_count = parseInt($display.text()) + 1;
                        $display.text(curr_count);
                    } else {
                        clearInterval(int);
                    }
                }, int_speed);
            }

            function countUp3(count) {
                var div_by = 100,
                    speed = Math.round(count / div_by),
                    $display = $('.count3'),
                    run_count = 1,
                    int_speed = 24;

                var int = setInterval(function() {
                    if (run_count < div_by) {
                        $display.text(speed * run_count);
                        run_count++;
                    } else if (parseInt($display.text()) < count) {
                        var curr_count = parseInt($display.text()) + 1;
                        $display.text(curr_count);
                    } else {
                        clearInterval(int);
                    }
                }, int_speed);
            }

            function countUp4(count) {
                var div_by = 100,
                    speed = Math.round(count / div_by),
                    $display = $('.count4'),
                    run_count = 1,
                    int_speed = 24;

                var int = setInterval(function() {
                    if (run_count < div_by) {
                        $display.text(speed * run_count);
                        run_count++;
                    } else if (parseInt($display.text()) < count) {
                        var curr_count = parseInt($display.text()) + 1;
                        $display.text(curr_count);
                    } else {
                        clearInterval(int);
                    }
                }, int_speed);
            }





            $(function() {
                countUp({{ count(\App\WebsiteUser::all()->get()) }});
                countUp2({{ count(\App\Models\Projects\Projects::all()) }});
                countUp3({{ count(\App\Models\Transactions\Transaction::all()) }});
                countUp4({{ count(\App\Models\Complaints\Complaints::all()) }});

            });

        </script>
    @endpush
    @push('css')
        <style>
            .chart-container {
                background-color: white;
                /* width: 300px;
                height: 300px; */
            }

        </style>

    @endpush
@endsection
