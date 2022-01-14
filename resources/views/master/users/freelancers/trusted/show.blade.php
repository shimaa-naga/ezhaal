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
                    <aside class="profile-nav col-lg-3">
                        <section class="panel">
                            <div class="user-heading round">
                                <a href="#">
                                    <img src="{{ $request->User->profilePhoto }}" alt="">
                                </a>
                                <h1>{{ $request->User->name }} {{ $request->User->last_name }}</h1>
                                <p>{{ $request->User->email }}</p>
                            </div>
                            <ul>
                                <li>{{ $request->User->mobile }}
                                </li>
                                <li>
                                    {{ $request->User->balance }}
                                </li>
                                <li>
                                    @if ($request->User->is_active)
                                        <span class="badge badge-success">{{ _i('Active') }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ _i('Not Active') }}</span>

                                    @endif
                                </li>
                            </ul>


                        </section>
                    </aside>
                    <aside class="profile-info col-lg-9">
                        <section class="panel">

                            <div class="">
                                <div class="bio-row">
                                    <p><span>{{ _i('Request Date') }}</span>: {{ $request->created_at }}</p>
                                </div>

                                <div class="bio-row">
                                    <p><span>{{ _i('Contract') }} </span>:
                                        <?php $file = $request->file; ?>
                                        <a href=" {{ route('downloadTrustedRequest', ['id' => $request->id]) }}"
                                           target="win-{{ basename($file) }}">{{ basename($file) }}
                                        </a>
                                    </p>
                                </div>
                                <div class="bio-row">
                                    <p><span>{{ _i('Status') }}</span>: {{ $request->status }}</p>
                                </div>

                            </div>

                            <p>
                                &nbsp;
                            </p>
                            <footer class="panel-footer">
                                @if($request->status!=\App\Help\Constants\TrustedStatus::APPROVED)
                                    <form method="post" style="display: :inline">
                                        @csrf
                                        <button class="btn btn-success pull-right">{{ _i('Approve') }}</button>
                                    </form>
                                @endif
                                @if($request->status!=\App\Help\Constants\TrustedStatus::REJECTED)

                                    <form method="post" style="display: inline">
                                        @method("delete")
                                        @csrf
                                        <button class="btn btn-danger pull-right">{{ _i('Reject') }}</button>
                                    </form>
                                @endif
                                <p class="nav nav-pills">
                                </p>
                            </footer>
                        </section>


                    </aside>
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
                        data: 'is_active',
                        name: 'status'
                    },
                    {
                        data: 'created',
                        name: 'created_at'
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
                            return '<img src="' + img + '" alt="' + img +
                                '"height="50" width="50"/>';

                        }
                    },
                    {
                        "targets": 4,
                        "data": 'status',
                        "render": function(data, type, row, meta) {
                            if (data == true)
                                return '<span class="badge badge-success">{{ _i('Active') }}</span>';
                            return '<span class="badge badge-danger">{{ _i('Not Active') }}</span>';
                        }
                    },
                    {
                        "targets": 6,
                        "data": 'id',
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
