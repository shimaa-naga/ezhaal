	<div class="modal fade modal_create " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		{{--    <div class="modal fade modal_create " id="langedit" role="dialog" aria-labelledby="exampleModalLabel" >--}}
		<div class="modal-dialog" role="document">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                        <h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
                    <form  action="{{route('master.permissions.storeTranslation')}}" method="POST" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
                        {{method_field('POST')}}
                        {{csrf_field()}}
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_data" value="">
                            <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >

                            <div class="box-body">
                                <div class="form-group ">
                                    <div class="row">
                                    <label for="" class="col-sm-2 control-label "> {{_i('Title')}} </label>
                                    <div class="col-md-10">
                                        <input type="text"  placeholder="{{_i('Translation of Permission')}}" name="title"  value="" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" required="" id="titletrans" >
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary" >{{_i('Save')}}</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>

				</div>
			</div>
		</div>
	</div>
