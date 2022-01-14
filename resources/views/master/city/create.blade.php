<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <h5 class="modal-title">{{ _i('Create new city') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <form action="{{ route('master.city.store') }}" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
			<div class="modal-body">
                <div class="form-group ">
                    <div class="row">
                    <label class=" col-sm-2 col-form-label"><?=_i('Language')?><span style="color: #F00;">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="lang_id" id="language_addform" required="" >
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
						<label class=" col-sm-2 col-form-label" for="country_id_add"><?=_i('Country')?><span style="color: #F00;">*</span></label>
						<div class="col-sm-10">
                            <select class="form-control" name="country_id" id="country_id_add" required="">
                                @foreach($countries_data as $country)
                                <option value="{{$country->country_id}}">{{$country->title}}</option>
                                @endforeach
                            </select>
						</div>
					</div>
                </div>

                <div class="form-group ">
                    <div class="row">
                    <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" name="title" required="" placeholder="{{_i('Please Enter City Title')}}">
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
                            $('#country_id_add').val("");
                        }
                    }
                });
            });

            $('#language_addform').click(function(){
                var languageID = $(this).val();

                if(languageID){
                    $.ajax({
                        type:"GET",
                        url:"{{route('master.country.list')}}?lang_id="+languageID,
                        dataType:'json',
                        success:function(res){
                            if(res){
                                $("#country_id_add").empty();
                                //$("#country_id_add").append('<option disabled selected>{{ _i('Choose') }}</option>');
                                $.each(res,function(key,value){
                                    $("#country_id_add").append('<option value="'+key+'">'+value+'</option>');
                                });

                            }else{
                                $("#country_id_add").empty();
                            }
                        }
                    });
                }else{
                    $("#country_id_add").empty();
                }
            });
        });
    </script>
@endpush
