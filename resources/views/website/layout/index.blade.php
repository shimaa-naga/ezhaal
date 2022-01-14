<!DOCTYPE html>
@php
$dir = \App\Help\Utility::getLangCode() == 'ar' ? 'rtl' : '';
@endphp
<html lang="{{ \App\Help\Utility::getWebsiteLang()->code }}" dir="{{ $dir }}">
@include('website.layout.include.style')

<body class="{{ $dir }}">

    <!--Loader-->
    <div id="global-loader"><img src="{{ asset('website2/assets/images/other/loader.svg') }}"
            class="loader-img floating" alt=""></div>

    <!-- ======= Top Bar ======= -->
    @include("website.layout.include.topbar")
    <!-- ======= Header ======= -->
    {{-- @include('website.layout.header') --}}
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    @yield('slider')

    <!--Breadcrumb-->
    <div class="bg-white border-bottom">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">{{ !empty($title) ? $title : '' }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{ _i('Home') }}</a>
                    </li>
                    @if (!empty($header_title))
                        @if (is_array($header_title))
                            @foreach ($header_title as $item)
                                <li class="breadcrumb-item " aria-current="page">
                                    {!! $item !!}
                                </li>

                            @endforeach
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{!! $header_title !!}</li>

                        @endif
                    @endif
                    {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Pages</a></li>
						<li class="breadcrumb-item active" aria-current="page">Domain List Right</li> --}}
                </ol>
            </div>
        </div>
    </div>
    <!--/Breadcrumb-->

    @if ($errors->all())


        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        {{-- <div class="row">
                    @yield('content')
                </div> --}}
        @yield('content')

    </div>




    <!-- Newsletter-->
    @include('website.layout.news_lettter')
    <!--/Newsletter-->

    @include('website.layout.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    @include('website.layout.include.script')
    @include('master.layout.include.session')
</body>

</html>
