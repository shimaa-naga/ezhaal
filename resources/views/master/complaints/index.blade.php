@extends('master.layout.index' ,['title' => _i('All Complaints')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('All Complaints') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('All Complaints') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->


    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
{{--                <header class="panel-heading">--}}
{{--                    <a href="#" class='btn btn-shadow btn-primary mb-2' data-toggle='modal' data-target='#add-Modal'>--}}
{{--                        <i class="fa fa-plus"> </i> {{ _i('Create new Complaint Status') }}--}}
{{--                    </a>--}}
{{--                </header>--}}
                <div class="card-body">
                    <div class="adv-table">
                        <table id="datatable" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"> {{_i('Complaint Title')}}</th>
                                <th class="text-center"> {{_i('Type')}}</th>
                                <th class="text-center"> {{_i('Status')}}</th>
                                <th class="text-center"> {{_i('Date')}}</th>
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
@endsection

@push('js')

    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('master.complaints.index')}}',
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'type_id'},
                {data: 'status_id'},
                {data: 'created'},
                {data: 'options'}
            ]
        });

    </script>
@endpush
