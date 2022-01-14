<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-TileColor" content="#0f75ff">
    <meta name="theme-color" content="#9d37f6">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon shortcut" href="{{asset('favicon.ico')}}" type="image/x-icon" />


    <!-- Title -->
    <title>{{ config('app.name') }} | {{ !empty($title) ? $title : '' }}</title>
    <link rel="stylesheet" href="{{ asset('website2/assets/fonts/fonts/font-awesome.min.css') }}">


    @if (\App\Help\Utility::getLangCode() == 'ar')
        <!-- Sidemenu Css -->
        <link href="{{ asset('website2/assets/css-rtl/sidemenu-rtl.css') }}" rel="stylesheet" />
        <link href="{{ asset('website2/assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css') }}" rel="stylesheet" />
        <!-- Dashboard Css -->
        <link href="{{ asset('website2/assets/css-rtl/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('website2/assets/css-rtl/admin-custom-rtl.css') }}" rel="stylesheet" />
        <!-- RTL Css -->
        <link href="{{ asset('website2/assets/css-rtl/rtl.css') }}" rel="stylesheet" />

    @else
        <link href="{{ asset('website2/assets/css/sidemenu.css') }}" rel="stylesheet" />
        <!-- Bootstrap Css -->
        <link href="{{ asset('website2/assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css') }}" rel="stylesheet" />

        <!-- Dashboard Css -->
        <link href="{{ asset('website2/assets/css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('website2/assets/css/admin-custom.css') }}" rel="stylesheet" />



    @endif

    <link href="{{ asset('website2/assets/plugins/tabs/style.css') }}" rel="stylesheet" />

    <!-- c3.js Charts Plugin -->
    <link href="{{ asset('website2/assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet" />

    <!-- Data table css -->
    <link href="{{ asset('website2/assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('website2/assets/plugins/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="{{ asset('website2/assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

    <!---Font icons-->
    <link href="{{ asset('website2/assets/plugins/iconfonts/plugin.css') }}" rel="stylesheet" />


    <!-- parsleyjs  css file -->
    <link href="{{ asset('custom/parsley.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('custom/noty/noty.css') }}">
    <script src="{{ asset('custom/noty/noty.min.js') }}"></script>

    <style>
        .form-control {
            color: #736d6d;
        }

        .badge-primary {
            color: #fff;
            background-color: #007bff;
        }

        .badge-secondary {
            color: #fff;
            background-color: #6c757d;
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }

        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }

        .badge-dark {
            color: #fff;
            background-color: #343a40;
        }

        tr.odd {
            background-color: white !important;
        }

    </style>

    @stack('css')
</head>
