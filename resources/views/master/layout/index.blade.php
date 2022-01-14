
<!doctype html>
<html lang="{{\App\Help\Utility::getLangCode()}}" dir="{{\App\Help\Utility::getLangCode()=="en" ? 'ltr' : 'rtl'}}">
@include('master.layout.include.style')

<body class="app sidebar-mini @if(\App\Help\Utility::getLangCode() == 'ar') rtl @endif" >
<div id="global-loader"><img src="{{asset('website2/assets/images/other/loader.svg')}}" class="loader-img floating" alt=""></div>
<div class="page">

    <div class="page-main">
        @include('master.layout.header')
        <!-- Sidebar menu-->
        @include('master.layout.sidebar')

            <!----- app-content --->
        <div class="app-content  my-3 my-md-5">
            <div class="side-app">
                <!-- page start-->
                <!--breadcrumbs start -->
                <!----
                <div class="page-header">
                    <h4 class="page-title">Email Users</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Email Users</li>
                    </ol>
                </div>
                ------>
                <!--breadcrumbs end -->
                <!------
                <div class="row">
                    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Send Individual Message</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4">
                                        <img src="../assets/images/svgs/admin/man.svg" class="imag-service" alt="user">
                                    </div>
                                    <div class="col-md-9 col-sm-8">
                                        <p class="mt-4 mt-sm-0">Send Email to One or more Users by you Selecting Individually</p>
                                        <a href="#" data-toggle="modal" data-target="#individual" class="btn-primary btn">Send Individual Message </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Send Group Message</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4">
                                        <img src="../assets/images/svgs/admin/team.svg" class="imag-service" alt="user">
                                    </div>
                                    <div class="col-md-9 col-sm-8">
                                        <p class="mt-4 mt-sm-0">Send Email to One or more Users Groups</p>
                                        <a href="#" data-toggle="modal" data-target="#group" class="btn-primary btn">Send Group Message </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ----->
                @yield('content')
                @include('master.layout.include.session')
            <!-- page end-->
            </div>
        </div>
            <!----- app-content end --->
    </div>


    <!--footer-->
    @include('master.layout.footer')
    <!-- End Footer-->
</div>

<!-- Dashboard js -->
@include('master.layout.include.script')


</body>
</html>
