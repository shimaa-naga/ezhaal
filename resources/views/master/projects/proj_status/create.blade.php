<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ _i('Create new project status') }}</h4>
			</div>
            <form action="{{ route('master.proj_status.store') }}" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
			<div class="modal-body">
                <div class="callout text-danger" id="masages_model" style="display:none">
                </div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label" for="title" >{{_i('title')}}<span style="color: #F00;">*</span> </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="title" id="title" required=""  placeholder="{{_i('Please Enter Project Status Title')}}">
						</div>
					</div>
			</div>
			<div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
				<button type="submit" class="btn btn-success waves-effect waves-light" >{{ _i('Save') }}</button>
			</div>
            </form>

        </div>
	</div>
</div>

@push('js')
    <script>
        $(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('action');

                $.ajax({
                   {{--// url: "{{ route('master.sliders.store')}}",--}}
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response.errors){
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
                            });
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
                            table.ajax.reload();
                            // $('#lang_add').val("");
                            $('#title').val("");
                            $('#lang_id').val("");
                            $('#masages_model').empty();
                        }
                    }
                });
            });
        });
    </script>
@endpush
