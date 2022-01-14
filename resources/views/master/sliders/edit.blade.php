<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit Slider') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="slider_id" name="slider_id">
                        <div class="form-group ">
                            <div class="row">
                            <label for="url" class=" col-sm-2 col-form-label"><?= _i('Link') ?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input  id="url" type="url" class="form-control" name="url" required="" placeholder="{{ _i('Please Enter Slider Url') }}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
       <label class="col-sm-2 col-form-label" for="checkbox">
        {{ _i('Publish') }}
       </label>
       <div class="mt-1 col-sm-6">
        <label>
         <input type="checkbox" class="js-switch-small" name='status' id='edit-switch'>
        </label>
       </div>
                            </div>
      </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="image">{{ _i('Image') }} <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" onchange="showImg(this)"
                                       class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="old_img" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                        <button class="btn btn-primary" type="submit" id="s_form_1"> {{ _i('Save') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
        <script>
            $('body').on('click', '.edit', function (e) {
                e.preventDefault();
                var sliderId = $(this).data('id');
                var url = $(this).data('url');
                var image = $(this).data('image');
                var status = $(this).data('status');

                $('#slider_id').val(sliderId);
                $('#url').val(url);
                $("#old_img").attr('src',"{{ asset('') }}/"+image);
                if ( status == 1 ) {
        $('#edit-switch').attr('checked', true);
        var element = $('#edit-switch');
        //changeSwitchery(element, true);
       }
       else
       {
        $('#edit-switch').attr('checked', false);
        var element = $('#edit-switch');
        //changeSwitchery(element, false);
       }
            });

            function showImg(input) {
                var filereader = new FileReader();
                filereader.onload = (e) => {

                    $("#old_img").attr('src', e.target.result).width(100).height(100);
                };

                filereader.readAsDataURL(input.files[0]);
            }

            $(function() {
                $('#form_edit').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('master.sliders.update') }}",
                        type: "POST",
                        data: new FormData(this),
                        dataType: 'json',
                        cache       : false,
                        contentType : false,
                        processData : false,
                        success: function(response) {
                            if (response == 'SUCCESS'){
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: "{{ _i('Saved Successfully') }}",
                                    timeout: 2000,
                                    killer: true
                                }).show();
                                $('.modal.modal_edit').modal('hide');
                                //table.ajax.reload();
                                getData();
                            }
                        }
                    });
                });
            });
        </script>
@endpush
