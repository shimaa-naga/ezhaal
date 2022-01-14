@extends('master.layout.index' ,['title' => _i('Roles')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Roles') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Roles') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->


    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <a href="#" class='btn btn-shadow btn-primary mb-2 text-white' data-toggle='modal' data-target='#add-Modal'>
                        <i class="fa fa-plus"></i> {{ _i('Create new role') }}
                    </a>
                </header>
                <div class="card-body">
                    <div class="adv-table">
                        <table  class="table table-striped table-bordered nowrap" id="datatable">
                            <thead>
                            <tr>
                                <th> {{_i('ID')}}</th>
                                <th>{{ _i('Name') }}</th>
                                <th>{{ _i('Created at') }}</th>
                                <th>{{ _i('Options') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->

    @include('master.security.roles.create')
    @include('master.security.roles.edit')
@endsection

@push('js')

    <script>
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('master.roles')}}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'options', name: 'options', orderable: true, searchable: true}
            ]
        });
        $(document).on('click', '.edit-row', function(){
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: "get",
                success: function (response) {

                    $('#edit-form .modal-name').val(response.role.name);
                    $('#edit-form .permissions').val(response.permissions).trigger('change');
                    $('#modal-id').val(response.role.id);
                }
            });
        });
        $('body').on('submit', '#add-form', function (e) {
            //alert('submit');
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                type: "post",
                data: new FormData(this),
                dataType: 'json',
                cache       : false,
                contentType : false,
                processData : false,
                success: function (response) {
                    if (response == 'success'){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_create').modal('hide');
                        $('#datatable').DataTable().draw(false);
                        $('#name').val("");
                        table.ajax.reload();
                    }
                },
            });
        });
        $('body').on('submit', '#edit-form', function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "POST",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                cache       : false,
                contentType : false,
                processData : false,
                success: function (response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: "{{ _i('Saved Successfully')}}",
                        timeout: 2000,
                        killer: true
                    }).show();
                    $('.modal').modal('hide');
                    $('#datatable').DataTable().draw(false);
                    table.ajax.reload();
                },
            });
        });

        $('#datatable').on('click', '.btn-delete[data-url]', function (e) {
            e.preventDefault();
            var url = $(this).data('url');

            $.ajax({
                url: url,
                method: "delete",
                type: 'DELETE',
                data: {method: '_DELETE', submit: true, _token: '{{ csrf_token() }}'
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
                        $('#datatable').DataTable().draw(false);
                        table.ajax.reload();
                    }
                }
            });
        });
    </script>
@endpush
