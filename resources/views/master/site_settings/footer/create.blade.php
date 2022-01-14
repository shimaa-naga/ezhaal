<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Create new footer') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('master.footer.store') }}" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
			<div class="modal-body">
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?=_i('Language')?><span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" name="lang_id"  required="" >
                                <option value="" selected disabled>{{_i('Select language')}}</option>
                                @foreach($languages as $lang)
                                    <option value="{{$lang->id}}">{{$lang->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="order_add"><?=_i('Order')?> <span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" name="order" required="">
                                <option selected disabled><?=_i('CHOOSE')?></option>
                                @for($i = 1 ; $i <= 10 ; $i++)
                                    <option value="<?=$i?>"><?=$i?></option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text"  class="form-control" name="title" required="" placeholder="{{_i('Please Enter Footer Title')}}">

                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="editor1"> <?=_i('Content')?> <span style="color: #F00;">*</span> </label>
                        </div>
                        <div class="col-md-9">
                             <textarea id="editor1" class="textarea form-control" name="content_add" required=""
                                       placeholder="{{_i('Place write content here')}}..."></textarea>
                        </div>
                    </div>
                </div>

			</div>
			<div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
				<button type="submit" class="btn btn-primary waves-effect waves-light" >{{ _i('Save') }}</button>
			</div>
            </form>

        </div>
	</div>
</div>

@push('js')
    <script>
        $(function() {
            CKEDITOR.replace('editor1',{
                height: 200,
                extraPlugins: 'colorbutton,colordialog',
            });

            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var data =new FormData(this);
                data.set("content_add",CKEDITOR.instances.editor1.getData());
                $.ajax({
                   {{--// url: "{{ route('master.sliders.store')}}",--}}
                    url: url,
                    type: "POST",
                    data: data,
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
                            $('#country_id_add').val("");
                        }
                    }
                });
            });

        });
    </script>
@endpush
