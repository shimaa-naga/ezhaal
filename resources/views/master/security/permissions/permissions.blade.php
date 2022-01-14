@extends('master.layout.index' ,['title' => _i('Permissions')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Permissions') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Permissions') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <a href="#" class='btn btn-shadow btn-primary mb-2 create add-permission text-white' data-toggle='modal' data-target="#modal-create" >
                        <i class="fa fa-plus"> </i> {{ _i('Create new permission') }}
                    </a>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table table-striped table-bordered nowrap" id="dataTable">
                            <thead>
                            <tr>
                                <th> {{_i('ID')}}</th>
                                <th> {{_i('Permission')}}</th>
                                <th> {{_i('Created at')}}</th>
                                <th> {{_i('Updated at')}}</th>
                                <th> {{_i('Options')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->


	@include('master.security.permissions.create')
	@include('master.security.permissions.edit')
	@include('master.security.permissions.translate')
@endsection
@push('css')
{{--    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>-->--}}
{{--   <!--- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> -->--}}
{{--    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
@endpush
@push('js')

{{--    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> -->--}}
{{--    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>--}}
{{--   <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->--}}
{{--    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>--}}


	<script  type="text/javascript">
		$(function () {
			var table =  $('#dataTable').DataTable({
                dataType: "json",
				processing: true,
				serverSide: true,

				ajax: '{{route('master.permissions')}}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'title', name: 'title'},
					{data: 'created_at', name: 'created_at'},
					{data: 'updated_at', name: 'updated_at'},
					{data: 'action', name: 'action', orderable: true, searchable: true}
				]
			});

			$('#form_add').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{route('master.permissions.store')}}",
					type: "POST",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							if(response.errors.name)
							{
								$( '#name-error' ).html( response.errors.name[0] );
							}
							if(response.errors.title)
							{
								$( '#title-error' ).html( response.errors.title[0] );
							}
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_create').modal('hide');
							$('#dataTable').DataTable().draw(false);
							$('#lang_add').val("");
							$('#title').val("");
							$('#name').val("");
							table.ajax.reload();
						}
					},
					error: function(data)
					{
						alert(data);
					}
				});
			});

			$('body').on('click', '.edit', function (e) {
				e.preventDefault();
				var permission_id = $(this).data('id');
				var lang_id = $(this).data('lang_id');
				var permission_name = $(this).data('name');
				var permission_title = $(this).data('title');

				$('#permission_id').val(permission_id);
				$('#lang_id').val(lang_id);
				$('#permission_name').val(permission_name);
				$('#permission_title').val(permission_title);
			});

			$('#form_edit').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{route('master.permissions.update')}}" ,
					type: "POST",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							if(response.errors.name)
							{
								$( '#form_edit #name-error' ).html( response.errors.name[0] );
							}
							if(response.errors.title)
							{
								$( '#form_edit #title-error' ).html( response.errors.title[0] );
							}
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_edit').modal('hide');
							table.ajax.reload();
						}
					}
				});
			});

			$('#dataTable').on('click', '.btn-delete[data-remote]', function (e) {
				e.preventDefault();
				var url = $(this).data('remote');

				$.ajax({
					url: url,
					method: "delete",
					type: "delete",
					data: {
						_token: '{{ csrf_token() }}',
					},
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

			$('body').on('click','.lang_ex',function (e) {
				e.preventDefault();
				var transRowId = $(this).data('id');
				var lang_id = $(this).data('lang');
				$.ajax({
					url: '{{ route('master.permissions.getLangValue') }}',
					method: "get",
					data: {
						lang_id: lang_id,
						transRowId: transRowId,
					},
					success: function (response) {
						if (response.data == 'false'){
							$('#titletrans').val('');
						}else{
							$('#titletrans').val(response.data.title);
						}
					}
				});

				$.ajax({
					url: '{{ route('master.get.lang') }}',
					method: "get",
					data: {
						lang_id: lang_id,
					},
					success: function (response) {
						$('.modal_create #header').empty();
						$('.modal_create #header').text('Translate to :'+response);
						$('#id_data').val(transRowId);
						$('#lang_id_data').val(lang_id);
					}
				});
			});

			$('body').on('submit','#lang_submit',function (e) {
				e.preventDefault();
				let url = $(this).attr('action');
				$.ajax({
					url: url,
					method: "POST",
                    type: 'POST',
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function (response) {
						if (response.errors){
							$('#masages_model').empty();
							$.each(response.errors, function( index, value ) {
								$('#masages_model').show();
								$('#masages_model').append(value + "<br>");
							});
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Translated Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_create').modal('hide');
							table.ajax.reload();
						}
					},
				});
			})
		});
	</script>
@endpush
