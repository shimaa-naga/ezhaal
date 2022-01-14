<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_trans " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header">{{_i('Trans To')}} :</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  action="{{ route('master.sliders.lang.store') }}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
                        @csrf
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >
                        <div class="box-body">
                            <div class="form-group ">
                                <div class="row">
                                <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                                <div class="col-sm-10">
                                    <input type="text" id="titletrans" class="form-control" name="title" required="" placeholder="{{_i('Please Enter Slider Title')}}">
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="description_trans" class="col-sm-2 control-label"> {{_i('description')}} </label>
                                <div class="col-sm-10">
                                    <textarea id="description_trans" class="form-control editor1" name="description" placeholder="{{_i('Please Enter description here...')}}"></textarea>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary" >
                                {{_i('Save')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
