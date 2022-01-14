<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" > {{_i('Edit Country')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="country_id" name="country_id">
                        <div class="form-group ">
                            <div class="row">
                            <label for="code" class=" col-sm-2 col-form-label"><?=_i('Code')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text"  id="code" class="form-control" name="code" required="" placeholder="{{_i('Please Enter Country Code')}}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="logo">{{_i('Logo')}} </label>
                            <div class="col-sm-10">
                                <input type="file" name="logo" id="logo" onchange="showImg(this)"
                                       class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="old_img" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
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
            var countryId = $(this).data('id');
            var code = $(this).data('code');
            var logo = $(this).data('logo');

            $('#country_id').val(countryId);
            $('#code').val(code);
            if(logo != ''){
                $("#old_img").attr('src',"{{asset('')}}/"+logo);
            }else{
                $("#old_img").attr('src',"{{asset('custom/index.png')}}");
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
                    url: "{{ route('master.country.update') }}",
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
