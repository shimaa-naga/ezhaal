<div class="modal modal_edit fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h5 class="modal-title" > {{_i('Edit Permission')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="">
                @method('PATCH')
                @csrf

                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" id="permission_id" name="permission_id">
                        <div class="form-group ">
                            <div class="row">
                            <label for="permission_name" class=" col-sm-4 col-form-label"><?=_i('Permission Name')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-8">
                                <input  id="permission_name" type="text" class="form-control" name="name" required="" placeholder="{{_i('PLease Enter Permission Name')}}">
                                <span class="text-danger">
									<strong id="name-error"></strong>
								</span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label for="permission_title" class=" col-sm-4 col-form-label"><?=_i('Arabic Title')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-8">
                                <input id="permission_title" type="text" class="form-control" name="title" required="" placeholder="{{_i('PLease Enter Permission Arabic Title')}}">
                                <span class="text-danger">
									<strong id="title-error"></strong>
								</span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                    <button class="btn btn-primary" type="submit" id="s_form_1"> {{_i('Save')}} </button>
                </div>

            </form>
        </div>
	</div>
</div>
