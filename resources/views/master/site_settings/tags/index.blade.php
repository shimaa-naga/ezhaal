@extends('master.layout.index' ,['title' => _i('Tags Settings')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Tags') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Tags') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="#" class='btn btn-shadow btn-primary mb-2 show-modal text-white' data-toggle='modal' data-target='#add-Modal'>
                            <i class="fa fa-plus"> </i> {{ _i('Create new tag') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"> {{_i('Code')}}</th>
                                <th class="text-center"> {{_i('Route')}}</th>

                                <th class="text-center"> {{_i('keywords')}}</th>
                                <th class="text-center"> {{_i('description')}}</th>


                                <th class="text-center"> {{_i('Options')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->
@include('master.site_settings.tags.create')
@include('master.site_settings.tags.edit')
@include("master.site_settings.tags.trans")

@endsection

@push('js')

    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'tags',
            columns: [
                {data: 'id'},
                {data: 'page_code'},
                {data: 'route'},

                {data: 'keywords'},
                {data: 'description'},


                {data: 'options'}
            ]
        });

        $('body').on('submit','.delform',function (e) {
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
