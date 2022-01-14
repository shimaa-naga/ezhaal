@extends('master.layout.index' ,['title' => _i('Requests')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Requests') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Requests') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover p-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"> {{ _i('User') }}</th>
                                <th class="text-center"> {{ _i('Transction Number') }}</th>
                                <th class="text-center"> {{ _i('Title') }}</th>
                                <th class="text-center"> {{ _i('Method') }}</th>
                                <th class="text-center"> {{ _i('Total') }}</th>
                                <th class="text-center"> {{ _i('Discount') }}</th>
                                <th class="text-center"> {{ _i('Commession') }}</th>
                                <th class="text-center"> {{ _i('User Amount') }}</th>
                                <th class="text-center"> {{ _i('Created Time') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        var table;
        $(document).ready(function() {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'transactions',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'user_id'
                    },
                    {
                        data: "trans_number"
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: "method_id"
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'discount_id'
                    },
                    {
                        data: 'commission'
                    },
                    {
                        data: 'user_amount'
                    },
                    {
                        data: 'created'
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
