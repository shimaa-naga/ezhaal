@extends('master.layout.index' ,['title' => _i('Projects Requests')])

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ _i('Requests') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Requests') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <div class="row">
        <div class="col-lg-12">
            <section class="card">

                <div class="card-body">

                    <div class="">


                        <table id="datatable" class="table  table-hover p-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center"> {{ _i('Title') }}</th>
                                    <th class="text-center"> {{ _i('Freelancer') }}</th>
                                    <th class="text-center"> {{ _i('Price') }}</th>
                                    <th class="text-center"> {{ _i('Payment Status') }}</th>
                                    <th class="text-center"> {{ _i('Created Time') }}</th>
                                    <th>{{_i("User Request")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('css')
    {{-- <link href="{{ asset('custom/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" /> --}}
@endpush
@push('js')
    {{-- <script type="text/javascript" src="{{ asset('custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script type="text/javascript">
        var table;
        $(document).ready(function() {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'requests',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {data:"freelancer"},
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
