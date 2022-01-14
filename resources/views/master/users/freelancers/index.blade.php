@extends('master.layout.index' ,['title' => _i('Freelancers')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Freelancers') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Freelancers') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered nowrap" id="dataTable">
                            <thead>
                            <tr>
                                <th>{{ _i('ID') }}</th>
                                <th>{{ _i('Image') }}</th>
                                <th>{{ _i('Name') }}</th>
                                <th>{{ _i('Email') }}</th>
                                <th>{{ _i('Type') }}</th>

                                <th>{{ _i('Status') }}</th>
                                <th>{{ _i('Joined on') }}</th>
                                <th>{{ _i('Options') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page end-->

@endsection

@push('js')

    {{-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> --}}
    <script type="text/javascript">
        $(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                "paging": true,
                pageLength: 10,
                ajax: '{{ \Request::getRequestUri() }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'account_type',
                        name: 'account'
                    },
                    {
                        data: 'is_active',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'options',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                        "targets": 1,
                        "data": 'id',
                        "render": function(data, type, row, meta) {
                            var img = '/uploads/users/user-default2.jpg';
                            if (data != null)
                                img = data;
                            return '<img src="' + img + '" alt="" height="50" width="50"/>';

                        }
                    },
                    {
                        "targets": 5,
                        "data": 'status',
                        "render": function(data, type, row, meta) {
                            if (data == true)
                                return '<span class="badge badge-success">{{ _i("Active") }}</span>';
                            return '<span class="badge badge-danger">{{ _i("Not Active") }}</span>';
                        }
                    },// new Date(Date.parse("2021-03-12T09:17:14.000000Z")).toLocaleDateString('en-CA');
                    {
                        "targets": 6,
                        "data": 'created_at',
                        "render": function(data, type, row, meta) {
                           return  new Date(Date.parse(data)).toLocaleDateString('en-CA');

                        }
                    },
                    {
                        "targets": 7,
                        "data": 'id',
                        "render": function(data, type, row, meta) {
                            return '<a href="users/' + data +
                                '/edit" class="btn btn-primary edit" title="{{ _i("Edit") }}"><i class="fa fa-edit"></i></a> <a href="#" data-url="users/' +
                                data +
                                '" class="btn btn-delete btn-danger" title="{{ _i("Delete") }}"><i class="fa fa-trash-o"></i></a>';
                        }
                    }
                ],
            });

            $('#dataTable').on('click', '.btn-delete[data-url]', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        method: '_DELETE',
                        submit: true,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.data === true) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: "{{ _i('Deleted Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload();
                        }
                    },
                    error: function(ex) {
                        // console.log(response);

                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: "{{ _i('Can not delete') }}",
                                timeout: 2000,
                                killer: true
                            }).show();


                    }
                });
            });

        });

    </script>
@endpush
