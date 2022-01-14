<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>{{ config('app.name') }} | {{ !empty($title) ? $title : '' }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('master/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('master/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('master/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('master/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('master/assets/bootstrap-datepicker/css/datepicker.css') }}" />

    <link href="{{ asset('master/assets/advanced-datatable/media/css/demo_page.css') }}" rel="stylesheet" />
    <link href="{{ asset('master/assets/advanced-datatable/media/css/demo_table.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('master/assets/data-tables/DT_bootstrap.css') }}" />
    <!--downloaded datatable script-->
    <link href="{{ asset('custom/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="{{ asset('master/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('master/css/style-responsive.css') }}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('master/js/html5shiv.js') }}"></script>
    <script src="{{ asset('master/js/respond.min.js') }}"></script>
    <![endif]-->

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
