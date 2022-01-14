<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit Tag') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="_method" value="PUT"> --}}
                    @method("put")
                    <div class="box-body">
                        <input type="hidden" id="rowId" name="row_id">
                        <div class="callout text-danger" id="messages_model" style="display:none">
                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" ><?=_i('Language')?></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control" name="lang_id" id="lang_edit">
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
                                    <label class="form-label" ><?=_i('Page Code')?> <span style="color: #F00;">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text"  class="form-control" name="page_code" id="page_code_edit" required="" placeholder="{{_i('Enter Page Code')}}">

                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" ><?=_i('Route')?> <span style="color: #F00;">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text"  class="form-control" name="route" id="route" required="" placeholder="{{_i('Enter route')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" ><?=_i('Meta keywords')?> <span style="color: #F00;">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea  class="form-control" name="keywords" id="keywords" required="" placeholder="{{_i('Enter keywords')}}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" ><?=_i('Meta Title')?> <span style="color: #F00;">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea  class="form-control" id="edit_title" name="title" required="" placeholder="{{_i('Enter title')}}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" ><?=_i('Meta description')?> <span style="color: #F00;">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea  class="form-control" name="description" id="desc" required="" placeholder="{{_i('Enter keywords')}}"></textarea>
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
</div>

@push('js')
    <script>
         var row_id;
        $('body').on('click', '.edit', function (e) {
            e.preventDefault();
           $('#messages_model').empty();
             row_id = $(this).data('id');
            var page_code = $(this).data('pagecode');

            var lang = $(this).data('lang');

            $('#rowId').val(row_id);
            $('#page_code_edit').val(page_code);
            $('#keywords').text($(this).data('meta'));
            $('#edit_title').text($(this).data('title'));

            $('#desc').text($(this).data('description'));
            $('#route').val($(this).data('route'));

        });


        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "tags/"+row_id,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response.errors){
                            $('#messages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#messages_model').show();
                                $('#messages_model').append(value + "<br>");
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
                            $('.modal.modal_edit').modal('hide');
                            table.ajax.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush
