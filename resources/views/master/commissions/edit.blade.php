<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" > {{_i('Edit commission')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="commission_id" name="row_id">
                        <div class="callout text-danger" id="messages_model" style="display:none">
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="title_edit" >{{_i('Title')}}<span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="title" required="" id="title_edit" >
                                    <option value="tax">{{_i('Tax')}}</option>
                                    <option value="profit">{{_i('Profit')}}</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="type_edit" >{{_i('Type')}}<span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="type" required="" id="type_edit" >
                                    <option value="perc">{{_i('Percentage')}}</option>
                                    <option value="net">{{_i('Net')}}</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="category_id_edit" >{{_i('Category')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category_id" id="category_id_edit">
                                    <option  value>------</option>
                                    @foreach ($categories as $category)

                                    <option value="{{ $category->id }}" imageUrl="{{ $category->imageUrl }}">
                                        {{ $category->title }} </option>
                                @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="price_edit" >{{_i('Price')}}<span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="price" id="price_edit" required="" placeholder="{{_i('Please Enter Commission Price')}}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="code_edit" >{{_i('Code')}} </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="code" id="code_edit" placeholder="{{_i('Please Enter Commission Code')}}">
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
        $('body').on('click', '.edit', function (e) {
            e.preventDefault();
            $('#messages_model').empty();
            var commissionId = $(this).data('commissionid');
            var title = $(this).data('title');
            var type = $(this).data('type');
            var categoryId = $(this).data('categoryid');
            var price = $(this).data('price');
            var code = $(this).data('code');

            $('#commission_id').val(commissionId);
            $('#title_edit').val(title);
            $('#type_edit').val(type);
            $('#price_edit').val(price);
            $('#code_edit').val(code);
            if(categoryId != ""){
                $('#category_id_edit').val(categoryId);
            }else{
                $('#category_id_edit').val("");
            }
        });

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master.commission.update') }}",
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
