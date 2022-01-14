<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" > {{_i('Edit bid status')}} </h4>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="status_id" name="row_id">
                        <div class="callout text-danger" id="messages_model" style="display:none">
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="title" >{{_i('title')}}<span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" id="status_title" required=""  placeholder="{{_i('Please Enter Bid Status Title')}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                        <button class="btn btn-success" type="submit" id="s_form_1"> {{_i('Save')}} </button>
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
            $('#messages_model').empty();
            var statusId = $(this).data('statusid');
            var title = $(this).data('title');

            $('#status_id').val(statusId);
            $('#status_title').val(title);
        });

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master.bid_status.update') }}",
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
