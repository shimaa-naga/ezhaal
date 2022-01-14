@extends('master.layout.index' ,['title' => _i('Buyers')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Buyers') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Buyers') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped table-responsive" id="dataTable">
                            <thead>
                            <tr>
                                <th>{{ _i('ID') }}</th>
                                <th>{{ _i('Name') }}</th>
                                <th>{{ _i('Logo') }}</th>
                                <th>{{ _i('Email') }}</th>
                                <th>{{ _i('Active') }}</th>
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
@push('css')
    <link rel="stylesheet" type="text/css" href="/master/assets/switchery/switchery.css" />
@endpush
@push('js')
    <script src="/master/assets/switchery/switchery.js"></script>

    <script type="text/javascript">
        function active(id) {
            $.ajax({
                url: "/master/company/"+id +"/activate",
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'POST',
                    submit: true,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);
                    if (response === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Updated Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                },
                error: function(response) {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: "{{ _i('Not found') }}",
                        timeout: 2000,
                        killer: true
                    }).show();
                }
            });
        }
        $(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ \Request::getRequestUri() }}',
                columns: [{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
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
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'options',
                        name: 'options',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function(settings) {
                    var elems = $('.js-switch-blue');
                    $.each(elems, function(i, elem) {
                        var switchery = new Switchery(elem, {
                            color: '#7c8bc7',
                            jackColor: '#9decff'
                        });
                    });
                }
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
