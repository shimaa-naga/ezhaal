<!DOCTYPE html>
@php
$dir = \App\Help\Utility::getLangCode() == 'ar' ? 'rtl' : '';
@endphp
<html lang="{{ \App\Help\Utility::getWebsiteLang()->code }}">
@include('website.layout.include.style')

<body class="{{ $dir }}">

    <!--Loader-->
    <div id="global-loader"><img src="{{ asset('website2/assets/images/other/loader.svg') }}" class="loader-img floating"
            alt=""></div>

    <!--Topbar-->
    <!-- ======= Top Bar ======= -->
    @include("website.layout.include.topbar")
    <!-- ======= topbar ======= -->
    {{-- @if ($errors->all())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @yield('content')


    <!-- Newsletter-->
    @include('website.layout.news_lettter')
    <!--/Newsletter-->

    <!--Footer Section-->
    @include('website.layout.footer')
    <!--/Footer Section-->

    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fa fa-rocket"></i></a>

    <!-- JQuery js-->
    @include('website.layout.include.script')
    @include('master.layout.include.session')


</body>

</html>
