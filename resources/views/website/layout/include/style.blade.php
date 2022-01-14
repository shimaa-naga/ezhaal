<head>
    <title>{{ config('app.name') }}| {{ !empty($title) ? $title : '' }}</title>
    @php
        $dir = \App\Help\Utility::getLangCode() == 'ar' ? '-rtl' : '';
    @endphp
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta property="fb:app_id" content="133656512001284" />

    @php
        //  dd(\App\Help\Utility::getLangCode());

        $tag = App\Models\SiteSettings\SettingTagData::join('setting_tags', 'setting_tags.id', 'tag_id')
            ->where('lang_id', \App\Help\Utility::websiteLang())
            ->where('route', request()->path())
            ->select('keywords', 'description', 'route', 'title')
            ->first();
        //dd($tag);
    @endphp

    @if ($tag != null)
        <meta content="" name="description" content="{{ $tag->description }}">
        <meta content="" name="keywords" content="{{ $tag->keywords }}">
        <!-- Social media -->
        <meta property="og:url" content="{{ request()->url() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ $tag->title }}" />
        <meta property="og:description" content="{{ $tag->description }}" />
        <meta property="og:image" content="{{ $tag->title }}" />
    @else
        <meta content="" name="description" content="{{ !empty($meta_description) ? $meta_description : '' }}">
        <meta content="" name="keywords" content="{{ !empty($meta_keywords) ? $meta_keywords : '' }}">

        <meta property="og:url" content="{{ request()->url() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ !empty($meta_title) ? $meta_title : '' }}" />
        <meta property="og:description" content="{{ !empty($meta_description) ? $meta_description : '' }}" />
        <meta property="og:image" content="{{ !empty($meta_image) ? $meta_image : '' }}" />
        <meta property="og:image:width" content="600" />
        <meta property="og:image:height" content="300" />



    @endif

    <!-- Bootstrap Css -->
    <link href="{{ asset('website2/assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Dashboard Css -->
    <link href="{{ asset('website2/assets/css' . $dir . '/style.css') }}" rel="stylesheet" />

    <!-- Font-awesome  Css -->
    <link rel="stylesheet" href="{{ asset('website2/assets/fonts/fonts/font-awesome.min.css') }}">
    @if ($dir == '-rtl')
        <!-- RTL Css -->
        <link href="{{ asset('website2/assets/css-rtl/rtl.css') }}" rel="stylesheet" />
    @endif
    <!--Horizontal Menu-->
    <link href="{{ asset('website2/assets/plugins/Horizontal2/Horizontal-menu/dropdown-effects/fade-down.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('website2/assets/plugins/Horizontal2/Horizontal-menu/color-skins/color.css') }}"
        rel="stylesheet" />

    <!--Select2 Plugin -->
    <link href="{{ asset('website2/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- Cookie css -->
    <link href="{{ asset('website2/assets/plugins/cookie/cookie.css') }}" rel="stylesheet">

    <!-- Countdown css-->
    <link href="{{ asset('website2/assets/plugins/count-down/flipclock.css') }}" rel="stylesheet" />

    <!-- Date Picker Plugin -->
    <link href="{{ asset('website2/assets/plugins/date-picker/spectrum.css') }}" rel="stylesheet" />

    <!-- Owl Theme css-->
    <link href="{{ asset('website2/assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="{{ asset('website2/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />

    <!--Font icons-->
    <link href="{{ asset('website2/assets/plugins/iconfonts/plugin.css') }}" rel="stylesheet">
    <link href="{{ asset('website2/assets/plugins/iconfonts/icons.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('custom/noty/noty.css') }}">
    <link href="{{ asset('custom/parsley.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('master/assets/plugins/fileuploads/css/dropify.css') }}" rel="stylesheet" type="text/css" />

    @if ($dir == '-rtl')
    <style>
        .float-right {
            float: left !important;
        }

    </style>
    @endif
    @stack('css')

</head>
