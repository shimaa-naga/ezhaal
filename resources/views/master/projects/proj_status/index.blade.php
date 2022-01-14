
@extends('master.layout.index' ,['title' => _i('Project Statuses')])

@section('content')
    <!--breadcrumbs start -->
    <ul class="breadcrumb">
        <li><a href="{{route('MasterHome')}}"><i class="fa fa-home"></i> {{_i('Home')}}</a></li>
        <li class="active">{{_i('Project Statuses')}}</li>
    </ul>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <a href="#" class='btn btn-shadow btn-primary mb-2' data-toggle='modal' data-target='#add-Modal'>
                        <i class="fa fa-plus"> </i> {{ _i('Create new Project Status') }}
                    </a>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table id="datatable" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"> {{_i('Title')}}</th>
                                <th class="text-center"> {{_i('Created Time')}}</th>
                                <th class="text-center"> {{_i('Options')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
@include('master.projects.proj_status.create')
@include('master.projects.proj_status.edit')
@endsection

@push('js')
    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('master.proj_status.index')}}',
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'created_at'},
                {data: 'options'}
            ]
        });

        $('body').on('submit','#delform',function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "delete",
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
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

    </script>
@endpush
