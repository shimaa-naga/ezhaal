

@extends('website.dashboard.index_inner', ['title' => _i('Transactions')])

@section('content')

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('My Transactions')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('My Transactions')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb-->
    @extends('website.layout.session_msg',["form"=>true])

    <!--User Dashboard-->
    <section class="sptb">
        <div class="container">
            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('My Transactions')}}</h3>
                        </div>

                            <div class="card-body">
                                @csrf
                                <table id="datatable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center"> {{ _i('Title') }}</th>
                                        <th class="text-center"> {{ _i('Price') }}</th>
                                        <th class="text-center"> {{ _i('Status') }}</th>
                                        <th class="text-center"> {{ _i('Created Time') }}</th>

                                        <th></th>


                                    </tr>
                                    </thead>
                                </table>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->
@endsection

@push('css')
    <link href="{{ asset('custom/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush
@push('js')
    <script type="text/javascript" src="{{ asset('custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        var table;
        $(document).ready(function() {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: "status"
                    },
                    {
                        data: 'created'
                    },
                    {
                        data: 'request'
                    },

                ]
            });

        });

        //delete
        $('body').on('submit', '#delform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "delete",
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data === true) {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        table.ajax.reload(false);
                    }
                }
            });
        });

    </script>

@endpush
