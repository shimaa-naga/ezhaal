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


                            <th>{{ _i('Status') }}</th>
                            <th>{{ _i('Created At') }}</th>
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
                ajax: 'trusted',
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created',
                        name: 'created_at'
                    },
                    {
                        data: 'request_id',
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
                            return '<img src="' + img + '" alt="' + img +
                                '"height="50" width="50"/>';

                        }
                    },
                    {
                        "targets": 4,
                        "data": 'status',
                        "render": function(data, type, row, meta) {
                            if (data == "{{\App\Help\Constants\TrustedStatus::APPROVED}}")
                                return '<span class="badge badge-success">'+data+'</span>';
                            return '<span class="badge badge-danger">'+data+'</span>';
                        }
                    },
                    {
                        "targets": 6,
                        "data": 'request_id',
                        "render": function(data, type, row, meta) {
                            return '<a href="' + data +
                                '/trust" class="btn btn-primary " title="{{ _i('View') }}"><i class="fa fa-eye"></i></a> ';
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
                    }
                });
            });

        });

    </script>
@endpush
