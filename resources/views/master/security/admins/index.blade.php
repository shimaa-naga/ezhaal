
@extends('master.layout.index' ,['title' => _i('Admins')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Admins') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Admins') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="{{route('master.admins.create')}}" class='btn btn-shadow btn-primary text-white mb-2 create add-permission' >
                            <i class="fa fa-plus"> </i> {{ _i('Create new Admin') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="display table table-striped table-bordered " id="dataTable">
                            <thead>
                            <tr>
                                <th>{{_i('ID')}}</th>
                                <th>{{_i('Name')}}</th>
                                <th>{{_i('Image')}}</th>
                                <th>{{_i('Email')}}</th>
                                <th>{{_i('Created At')}}</th>
                                <th>{{_i('Options')}}</th>
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
@push('css')
{{--    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
@endpush
@push('js')
{{--    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>--}}

    <script  type="text/javascript">
        $(function () {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('master.admins') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'options', name: 'options', orderable: false, searchable: false}
                ]
            });

            $('#dataTable').on('click', '.btn-delete[data-url]', function (e) {
                e.preventDefault();
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true, _token: '{{ csrf_token() }}'},
                    success: function (response) {
                    // console.log(response);
                    if (response.data === true){
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully')}}",
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
