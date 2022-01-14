<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <h5 class="modal-title">{{ _i('Create new work method') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <form action="{{ route('master.work_method.store') }}" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
			<div class="modal-body">
                <div class="form-group ">
                    <div class="row">
                    <label class=" col-sm-2 col-form-label"><?=_i('Language')?><span style="color: #F00;">*</span></label>
                    <div class="col-sm-10">
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
                    <label class=" col-sm-2 col-form-label"><?=_i('Icon')?></label>
                    <div class="col-sm-10">
{{--                        <select class="selectpicker">--}}
{{--                            <option data-icon="<i class='fa fa-address-book-o' aria-hidden='true'></i>Option1"><i class="fa fa-email"></i> Email</option>--}}
{{--                            <option data-content="<i class='fa fa-calculator' aria-hidden='true'></i>Option2"></option>--}}
{{--                            <option data-content="<i class='fa fa-heart' aria-hidden='true'></i>Option3"></option>--}}
{{--                        </select>--}}
                        <select id="mySelect" data-show-content="true" class="form-control icon_add" name="icon">
                            <option value="" selected disabled>{{_i('Select')}}...</option>
                            <option value="fa fa-plus-circle">&#xf055; fa-plus-circle</option>
                            <option value="fa fa-clock-o">&#xf017; fa-clock-o</option>
                            <option value="fa fa-money">&#xf0d6; fa-money</option>
                            <option value="fa fa-check">&#xf00c; fa-check</option>
                            <option value="fa fa-check-circle">&#xf058; fa-check-circle</option>
                            <option value="fa fa-check-square">&#xf14a; fa-check-square</option>
                            <option value="fa fa-bell">&#xf0f3; fa-bell</option>
                            <option value="fa fa-bullhorn">&#xf0a1; fa-bullhorn</option>
                            <option value="fa fa-calendar">&#xf073; fa-calendar</option>
                            <option value="fa fa-book">&#xf02d; fa-book</option>
                            <option value="fa fa-bookmark">&#xf02e; fa-bookmark</option>
                            <option value="fa fa-comment">&#xf075; fa-comment</option>
                            <option value="fa fa-comments">&#xf086; fa-comments</option>
                            <option value="fa fa-code">&#xf121; fa-code</option>
                            <option value="fa fa-envelope">&#xf0e0; fa-envelope</option>
                            <option value="fa fa-cog">&#xf013; fa-cog</option>
                            <option value="fa fa-cogs">&#xf085; fa-cogs</option>
                            <option value="fa fa-edit">&#xf044; fa-edit</option>
                            <option value="fa fa-star">&#xf005; fa-star</option>
                            <option value="fa fa-thumbs-o-up">&#xf164; fa-thumbs-o-up</option>
                            <option value="fa fa-align-left">&#xf036; fa-align-left</option>
                            <option value="fa-align-right">&#xf038; fa-align-right</option>
                            <option value="fa fa-ambulance">&#xf0f9; fa-ambulance</option>
                            <option value="fa fa-anchor">&#xf13d; fa-anchor</option>
                            <option value="fa fa-android">&#xf17b; fa-android</option>
                            <option value="fa fa-angle-double-down">&#xf103; fa-angle-double-down</option>
                            <option value="fa fa-angle-double-left">&#xf100; fa-angle-double-left</option>
                            <option value="fa fa-angle-double-right">&#xf101; fa-angle-double-right</option>
                            <option value="fa fa-angle-double-up">&#xf102; fa-angle-double-up</option>
                        </select>
                    </div>
                </div>
                </div>

                <div class="form-group ">
                    <div class="row">
						<label class=" col-sm-2 col-form-label" for="order_add"><?=_i('Order')?> <span style="color: #F00;">*</span></label>
						<div class="col-sm-10">
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
                    <label class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" name="title" id="title_add" required="" placeholder="{{_i('Please Enter Title')}}">
                    </div>
                </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label" for="editor1"> <?=_i('Description')?><span style="color: #F00;">*</span> </label>
                    <div class="col-sm-10">
                        <textarea class="textarea form-control" name="description" required="" id="description_add"
                            placeholder="{{_i('Place write description here')}}..."></textarea>
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
                var data =new FormData(this);
                $.ajax({
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
                            $('#title_add').val("");
                            $('#description_add').val("");
                            $('.icon_add').val("");
                        }
                    }
                });
            });

        });
    </script>
@endpush
