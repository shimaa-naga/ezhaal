<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Create new tag') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="tags" method="POST" id='form_add' data-parsley-validate=""
                enctype="multipart/form-data">
            @csrf {{ method_field('POST') }}
            @method("POST")
            <div class="modal-body ">
                <div class="callout text-danger" id="masages_model" style="display:none">
                </div>

                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?=_i('Language')?></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" name="lang_id" id="langId">
                                @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?= _i('Page Code') ?> <span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="page_code" class="form-control" name="page_code"  required="" placeholder="{{ _i('Please Enter Page Code') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?= _i('Route') ?> <span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="route"  required="" placeholder="{{ _i('Enter route') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?= _i('Keywords') ?> <span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control"  name="meta" required="" placeholder="{{ _i('Enter Meta Keywords') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?= _i('Title') ?> <span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control"  name="title" required="" placeholder="{{ _i('Enter Meta title') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" ><?= _i('Meta Description') ?> <span style="color: #F00;">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control"  name="description" required="" placeholder="{{ _i('Enter Meta description') }}"></textarea>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{ _i('Save') }}</button>

            </div>
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
                                       {{-- // url: "{{ route('master.sliders.store')}}", --}}
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
                                                    text: "{{ _i('Saved Successfully') }}",
                                                    timeout: 2000,
                                                    killer: true
                                                }).show();
                                                $('.modal.modal_create').modal('hide');
                                                table.ajax.reload();
                                                $('#page_code').val("");
                                                $('#meta').val("");
                                            }
                                        }
                                    });
                                });
                            });
                            $(".show-modal").on("click", function() {
                                $('#masages_model').empty();
                            });
                            $(document).on('show.bs.modal', '.start_modal', function (e) {
                                $('#masages_model').empty();
                            });

                        </script>
@endpush
