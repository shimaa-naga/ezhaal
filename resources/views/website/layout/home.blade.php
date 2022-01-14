
<!doctype html>
@php
      $dir =( \App\Help\Utility::getLangCode()=="ar")? "rtl": "";
@endphp
<html lang="{{\App\Help\Utility::getWebsiteLang()->code}}" dir="{{$dir}}">
@include('website.layout.include.style')
<body class="{{$dir}}">

<!--Loader-->
<div id="global-loader"><img src="{{asset('website2/assets/images/other/loader.svg')}}" class="loader-img floating" alt=""></div>

<!--Topbar-->
@include('website.layout.include.topbar')


<!--Sliders Section-->
@yield('slider')

<!--/Sliders Section-->
@yield('content')

@include("website.layout.footer")

<!-- Back to top -->
<a href="#top" id="back-to-top" ><i class="fa fa-rocket"></i></a>

<!-- JQuery js-->
@include('website.layout.include.script')



</body>
</html>
