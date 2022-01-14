<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Create new slider') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('master.sliders.store') }}" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
			<div class="modal-body">
                <div class="form-group ">
                    <div class="row">
						<label class=" col-sm-2 col-form-label"><?=_i('Link')?> <span style="color: #F00;">*</span></label>
						<div class="col-sm-10">
							<input type="url" id="link_add" class="form-control" name="url" data-parsley-type="url" required="" placeholder="{{_i('Please Enter Slider Url')}}">
						</div>
                    </div>
					</div>
                <div class="form-group ">
                    <div class="row">
						<label class="col-sm-2 col-form-label" for="image">{{_i('Image')}} <span style="color: #F00;">*</span></label>
						<div class="col-sm-10">
							<input type="file" name="image" id="image_add" class="btn btn-default form-control" accept="image/*" required="">
							<span class="text-danger invalid-feedback">
								<strong>{{$errors->first('image')}}</strong>
							</span>
						</div>
                    </div>
					</div>
                <div class="form-group ">
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="checkbox">
                            {{_i('Publish')}}
                        </label>
                        <div class="mt-1 col-sm-6">
                            <label>
                                <input type="checkbox" class="js-switch-small" name='status' checked="">
                            </label>
                        </div>
                    </div>
                    </div>
			</div>
			<div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
{{--				<button type="submit" class="btn btn-success waves-effect waves-light" form='form_add'>{{ _i('Save') }}</button>--}}
				<button type="submit" class="btn btn-primary waves-effect waves-light" >{{ _i('Save') }}</button>
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
                            //table.ajax.reload();
                            getData();
                            // $('#lang_add').val("");
                            $('#link_add').val("");
                            $('#image_add').val("");
                            $('#checkbox').val("");
                        }
                    }
                });
            });
        });
    </script>
@endpush
