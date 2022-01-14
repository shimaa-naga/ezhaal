

<div class="modal modal_create fade" id="modal-create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h5 class="modal-title" > {{_i('Create new permission')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <form id="form_add" class="form-horizontal" action="{{route('master.permissions.store')}}" method="POST" data-parsley-validate="">
                @csrf
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group ">
                            <div class="row">
                            <label class=" col-sm-4  col-form-label"><?=_i('Permission Name')?>
                                <span style="color: #F00;">*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id='name' required="" placeholder="{{_i('Please Enter Permission Name')}}">
                                <span class="text-danger">
									<strong id="name-error"></strong>
								</span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class=" col-sm-4 col-form-label"><?=_i('Arabic Title')?>
                                <span style="color: #F00;">*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="title" class="form-control" name="title" required="" placeholder="{{_i('Please Enter Arabic Title')}}">
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
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
