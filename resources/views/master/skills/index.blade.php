
@extends('master.layout.index' ,['title' => _i('User Skills')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('User Skills') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('User Skills') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="#" class='btn btn-shadow btn-primary mb-2 text-white' data-toggle='modal' data-target='#add-Modal'>
                            <i class="fa fa-plus"> </i> {{ _i('Create new Skills') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
            </div>
        </div>
    </div>

    <!-- page end-->
@include('master.skills.create')
@include('master.skills.trans')
@endsection

@push('js')

    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('master.skills.index')}}',
            columns: [
                {data: 'id'},
                {data: 'skill_title'},
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
