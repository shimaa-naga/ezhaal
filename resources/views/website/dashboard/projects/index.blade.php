@extends('website.layout.index', ['title' => _i('All Projects'),'header_title' => _i('Projects')])

@section('content')
    <!--Left Side Content-->
    <div id="mySidebar" class="sidebar">
        @include('website.dashboard.projects.partial.projects_nav')
    </div>
    <!--left Side Content-->
    <div id="main">
        <!--Add lists-->
        <div class="card mb-0">
            <div class="card-body"><a id="a_filter" href="javascript:openNav()"><i class="fa fa-align-justify"></i></a>
                <div class="item2-gl ">
                    <div class="item2-gl-nav d-flex">
                        <h6 class="mb-0 mt-2">
                            @if ($total > 0)
                                {{ _i('Showing') }} 1 {{ _i('to') }} {{ $limit > $total ? $total : $limit }}
                                {{ _i('of') }} {{ $total }}
                                {{ _i('entries') }}
                            @endif
                        </h6>
                        <ul class="nav item2-gl-menu m{{ \App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l' }}-auto">
                            <li class=""><a href="#tab-11" class="active show" data-toggle="tab"
                                    title="List style"><i class="fa fa-list"></i></a></li>
                            <li><a href="#tab-12" data-toggle="tab" class="" title="Grid"><i
                                        class="fa fa-th"></i></a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <label class="mr-2 mt-1 mb-sm-1">{{ _i('Sort By') }}:</label>
                            <select name="sort" id="sel_sort" class="form-control select-sm w-70">
                                <option value="latest">{{ _i('Latest') }}</option>
                                <option value="old">{{ _i('Oldest') }}</option>
                                <option value="low-price">{{ _i('Price:Low-to-High') }}</option>
                                <option value="high-price">{{ _i('Price:Hight-to-Low') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="tab-content" id="projects_filter">
                        @include('website.dashboard.projects.partial.projects_ajax')

                    </div>
                    {{ $projects->appends(Request::except('page'))->links() }}

                </div>

            </div>
        </div>
        <!--Add lists-->
    </div>

    <!-- Content section End -->
@endsection
@push('css')
    <style>
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 50PX;
            left: 0;
            /* background-color: #fff; */
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 50px;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            /* position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px; */
            margin-left: 50px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            padding: 10px 15px;
            border: none;
        }

        .openbtn:hover {
            background-color: #444;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

    </style>
@endpush
@push('js')
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "300px";
            document.getElementById("main").style.marginLeft = "300px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });
        var page = 0;
        var sort = "";
        $(document).ready(function() {
            $(".tab-pane").first().addClass("active");
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                page = $(this).attr('href').split('page=')[1];

                getData(page);
            });

        });

        function getData(page) {
            var active_tab = "#" + $(".tab-pane.active").attr("id");
            $.ajax({
                url: '?page=' + page + "&sort=" + sort,
                type: "post",
                method: "post",
                data: new FormData($('#filter-form')[0]),
                cache: false,
                contentType: false,
                processData: false,
            }).done(function(response) {
                $('#projects_filter').empty().html(response);
                $(active_tab).addClass("active");
                //$("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }


        $(document).on('change', '#filter-form :input', function() {
            getData(page);

        });
        $(document).on('click', '#btn_filter', function() {
            getData(page);

        });
        $(document).on('change', '#sel_sort', function() {
            sort = $("#sel_sort").val();
            getData(page);

        });

        $("#mySlider").slider({
            range: true,
            min: 1,
            max: 2000,
            values: [5, {{ $max }}],
            slide: function(event, ui) {
                $("#price").val(ui.values[0] + "-" + ui.values[1]);
                $("range_").val(1);
            }
        });

        // $("#price").val($("#mySlider").slider("values", 0) +
        //     "-" + $("#mySlider").slider("values", 1));
    </script>
@endpush
