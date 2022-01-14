
<!DOCTYPE html>
<html lang="en">

@include('master.layout.include.style')

<body>

<section id="container" class="">
    <!--header start-->
    @include('master.layout.header')
    <!--header end-->
    <!--sidebar start-->
    @include('master.layout.nav')
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->

            <!--breadcrumbs start -->
            <!-- <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Library</a></li>
                <li class="active">Data</li>
             </ul> -->
            <!--breadcrumbs end -->

            @yield('content')
            @include('master.layout.include.session')
            <!-- page end-->
        </section>
    </section>
    <!--main content end-->

    <!--footer start-->
    <footer class="site-footer">
        <div class="text-center">
            2013 &copy; FlatLab by VectorLab.
            <a href="#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->
</section>

@include('master.layout.include.script')

</body>
</html>
