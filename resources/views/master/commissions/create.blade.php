<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _i('Create new commission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{ route('master.commission.store') }}" method="POST" id='form_add' data-parsley-validate=""
                enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
                <div class="modal-body">
                    <div class="callout text-danger" id="masages_model" style="display:none">
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="title">{{ _i('Title') }}<span
                                    style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="title" id="title" required="">
                                    <option value="tax">{{ _i('Tax') }}</option>
                                    <option value="profit">{{ _i('Profit') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="type">{{ _i('Type') }}<span
                                    style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="type" id="type" required="">
                                    <option value="perc">{{ _i('Percentage') }}</option>
                                    <option value="net">{{ _i('Net') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="category_id">{{ _i('Category') }}</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category_id" id="category_id">
                                    <option selected disabled value>{{ _i('Please select project category') }}</option>
                                    @foreach ($categories as $category)

                                        <option value="{{ $category->id }}" imageUrl="{{ $category->imageUrl }}">
                                            {!! $category->title !!} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="price">{{ _i('Price') }}<span
                                    style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="price" id="price" required=""
                                    placeholder="{{ _i('Please Enter Commission Price') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="code">{{ _i('Code') }} </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="{{ _i('Please Enter Commission Code') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ _i('Save') }}</button>
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
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.errors) {
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
                            });
                        }
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_create').modal('hide');
                            table.ajax.reload();
                            // $('#lang_add').val("");
                            $('#title').val("");
                            $('#type').val("");
                            $('#category_id').val("");
                            $('#price').val("");
                            $('#code').val("");
                        }
                    }
                });
            });
        });
    </script>
@endpush
