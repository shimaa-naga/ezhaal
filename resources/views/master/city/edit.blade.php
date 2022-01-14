<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" > {{_i('Edit City')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="city_id" name="city_id">

                        <div class="form-group ">
                            <div class="row">
                            <label class=" col-sm-2 col-form-label"><?=_i('Language')?><span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="lang_id" id="langId" required="">
                                    <option value="" selected disabled>{{_i('Select language')}}</option>
                                    @foreach($languages as $lang)
                                        <option value="{{$lang->id}}">{{$lang->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                            <label for="country_id_edit" class=" col-sm-2 col-form-label"><?=_i('Country')?><span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="country_id" id="country_id_edit" required="">
                                    @foreach($countries_data as $country)
                                        <option value="{{$country->country_id}}">{{$country->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                            <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" id="title_edit" class="form-control" name="title" required="" placeholder="{{_i('Please Enter City Title')}}">
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
            var cityId = $(this).data('id');
            var country = $(this).data('countryid');
            var lang = $(this).data('lang');
            var title = $(this).data('title');

            $('#city_id').val(cityId);
            //$('#country_id_edit').val(country);
            $('#langId').val(lang);
            $('#title_edit').val(title);

            $.ajax({
                type:"GET",
                url:"{{route('master.country.list')}}?lang_id="+lang,
                dataType:'json',
                success:function(res){
                    if(res){
                        html = $("#country_id_edit").empty();
                        // html += $("#country_id_2").append('<option disabled >{{ _i('Choose') }}</option>');
                        $.each(res,function(key,value){
                            html += $("#country_id_edit").append('<option value="'+key+'">'+value+'</option>');
                        });

                        $('#country_id_edit').val(country);
                    }else{
                        $("#country_id_edit").empty();
                    }
                }
            });
        });

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master.city.update') }}",
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

        // edit form
        $('#langId').click(function(){
            // var saved_lang = $("#saved_lang_id").val();
            var languageID = $(this).val();

            $.ajax({
                type:"GET",
                url:"{{route('master.country.list')}}?lang_id="+languageID,
                dataType:'json',
                success:function(res){
                    if(res){
                        html = $("#country_id_edit").empty();
                       // html += $("#country_id_2").append('<option disabled >{{ _i('Choose') }}</option>');
                        $.each(res,function(key,value){
                            html += $("#country_id_edit").append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        $("#country_id_edit").empty();
                    }
                }
            });

        });
    </script>
@endpush
