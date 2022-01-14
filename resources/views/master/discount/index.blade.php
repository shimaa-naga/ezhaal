@extends('master.layout.index' ,['title' => _i('Discounts')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Discounts') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Discounts') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="discounts/create" class='btn btn-shadow btn-primary mb-2 text-white'>
                            <i class="fa fa-plus"> </i> {{ _i('Create New Discount') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"> {{ _i('Title') }}</th>
                                <th class="text-center"> {{ _i('Price') }}</th>

                                <th class="text-center"> {{ _i('Status') }}</th>
                                <th class="text-center"> {{ _i('Type') }}</th>
                                <th class="text-center"> {{ _i('For') }}</th>
                                <th class="text-center"> {{ _i('Created Time') }}</th>
                                <th class="text-center"> {{ _i('Options') }}</th>
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
    <link href="{{ asset('master/css/switch.css') }}" rel="stylesheet" />

@endpush
@push('js')
    <script>
        function enable(obj,id) {
            var bol = $(obj).is(":checked");
            //alert(bol);
            $.ajax({
                url: "discounts/enable/" + id,
                type: "Post",
                data: {
                    status: bol,
                    _token: '{{ csrf_token() }}',
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    if (response == 'SUCCESS') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('State changed successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                }
            });
        }
        // $('.enabled').on("click", function () {
        //     $('.disabled').prop("checked", false);
        // });
        // $('.disabled').on("click", function () {
        //     $('.enabled').prop("checked", false);
        // });
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'discounts',
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
                    data: 'enabled'
                },
                {
                    data: 'module'
                },
                {
                    data: 'user_type'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'options'
                }
            ]
        });

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
                        table.ajax.reload();
                    }
                }
            });
        });

    </script>
@endpush
