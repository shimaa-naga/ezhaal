@extends('master.layout.index' ,['title' => _i('Work Method')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Work Method') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Work Method') }}</li>
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
                            <i class="fa fa-plus"> </i> {{ _i('Create new Work Method') }}
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
@include('master.site_settings.work_method.create')
@include('master.site_settings.work_method.edit')
@include('master.site_settings.work_method.trans')
@endsection
@push('css')
    <!--- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="{{asset('custom/font-awesome.min.css')}}" rel="stylesheet" />
    <style>
        select{
            font-family: fontAwesome
        }
    </style>
@endpush
@push('js')

    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('master.work_method.index')}}',
            columns: [
                {data: 'id'},
                {data: 'work_title'},
                {data: 'order'},
                {data: 'icon'},
                {data: 'created_at'},
                {data: 'options'}
            ],
            'drawCallback': function () {
                $('.sort_hight').click(sort_hight);
                $('.sort_bottom').click(sort_bottom);
            }
        });

        function sort_hight(){
            var rowId = $(this).data('id');
            //console.log(rowId);
            $.ajax({
                url: '{{route("master.work_method.sort")}}',
                type: 'get',
                dataType: 'json',
                data: {row_sort_hightId: rowId},
                success: function (res) {
                    table.ajax.reload();
                }
            });
        }

        function sort_bottom(){
            var rowId = $(this).data('id');
            // console.log(rowId);
            $.ajax({
                url: '{{route("master.work_method.sort")}}',
                type: 'get',
                dataType: 'json',
                data: {row_sort_bottomId: rowId},
                success:function (res) {
                    table.ajax.reload();
                }
            })
        }

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
