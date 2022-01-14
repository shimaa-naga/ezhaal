<div class="form-group ">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label" id="examplenameInputname2">
                {{ _i('Price Type') }}</label>
        </div>
        <div class="col-md-9">
            <select class="form-control" name="price_type" id="sel_price_type" onchange="select_price(this)" required>
                <option value="">---</option>
                <option value="un">{{ _i('Unspecified') }}
                </option>
                @if ($type == 'service')
                    <option value="more">{{ _i('More than') }}</option>

                @else
                    <option value="less">{{ _i('Less than') }}</option>
                @endif
                <option value="range">{{ _i('Range') }}</option>
            </select>
        </div>

    </div>
</div>
<div class="form-group d-none " id="less">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label">
                {{ _i('Maximum Price') }}</label>
        </div>
        <div class="col-md-9">
            <input type="number" class="form-control" value="{{ isset($project) ? $project->max_budget : '' }}"
                name="_price" placeholder='{{ _i('Less than') }}'>
        </div>
    </div>
</div>
<div class="form-group d-none " id="more">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label">
                {{ _i('Minimum Price') }}</label>
        </div>
        <div class="col-md-9">
            <input type="number" class="form-control" value="{{ isset($project) ? $project->budget : '' }}"
                name="min_price" placeholder='{{ _i('More than') }}'>
        </div>
    </div>
</div>
<div class="form-group d-none" id="range">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label">
                {{ _i('Between') }}</label>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="budget"
                value="{{ isset($project) ? $project->budget : '' }}" id="budget" data-parsley-lt="#max_price"
                placeholder='{{ _i('Minimum Price') }}'>

        </div>
        <div class="col-md-3">

            <input type="number" data-parsley-gt="#budget" class="form-control"
                value="{{ isset($project) ? $project->max_budget : '' }}" name="max_price" id="max_price"
                placeholder='{{ _i('Max Price') }}'>
        </div>
    </div>
</div>
<div class="form-group ">
    <div class="row">
        <div class="col-md-3">
            <label class="form-label">
                {{ _i('Expire date') }}</label>
        </div>
        <div class="col-md-4">
            <input class="form-control" required=""
                value="{{ isset($project) ? $project->expiryDate : date('Y-m-d', strtotime('+7 day')) }}"
                parsley-type="dateIso" data-date-format="YY-MM-DD" type="date" data-type="dateIso" name="expiry_date">

        </div>
        <div class="col-md-4">
            <input class="form-control" id="tp3" placeholder="{{ _i('time') }}" type="time" name="expiry_time"
                value="{{ isset($project) ? $project->expiryTime : date('H:i') }}">

        </div>


    </div>
</div>
@push('js')
    <script type="text/javascript">
        @if (isset($project))
            $(function() {
            $("#sel_price_type").val("{{ $project->priceType }}");
            select_price($("#sel_price_type"));
            });
        @endif

        function select_price(obj) {
            $("#range").addClass("d-none");
            $("#less").addClass("d-none");
            $("#more").addClass("d-none");


            //clear
            var arr = ["range", "less", "more"]
            for (i = 0; i < arr.length; i++) {
                $("#" + arr[i] + " input").each(function(i, elem) {
                    $(elem).removeAttr("required");
                });
            }
            var val = $(obj).val();
            if (val != "") {
                $("#" + val).removeClass("d-none");
                $("#" + val + " input").each(function(i, elem) {
                    $(elem).attr("required", "");
                });
            }
            $('#frm_create').parsley().refresh();
        }

        function getAttr(sel = "sel_category") {

            var id = $("#" + sel).val();
            if (id == "")
                return;
            $.ajax({
                url: "{{ url('dash/project') }}/" + id + "/attr?type={{ $type }}",
                type: "get",
                datatype: "html"
            }).done(function(data) {

                $("#attr").empty().html(data);
                $(".js-example-basic-single").select2();
                $(".js-example-basic-multiple").select2();
                drEvent = $('.dropify').dropify({
                    //defaultFile: imagenUrl
                });
                @if (old('attr') !== null)
                    @foreach (old('attr') as $attr => $val)
                        $("[name='attr[{{ $attr }}]']").val('{{ $val }}');
                    @endforeach
                @endif

            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: "{{ _i('No response from server') }}",
                    timeout: 2000,
                    killer: true
                }).show();
            });
        }
    </script>
    <script>
        @if (old('parent_category') !== null)
            $(function(){
            $("#sel_parent_category").val({{ old('parent_category') }});
            parnet_selected();
            //price_type
            $("#sel_price_type").val("{{ old('price_type') }}");
            select_price( $("#sel_price_type"));

            });

        @endif



        $(function() {


            $("#sel_parent_category").select2({
                templateResult: formatState
            });
            $('#sel_category').select2({
                templateResult: formatState,
            });



        });

        function formatState(state) {

            if (!state.id) {
                return state.text;
            }
            var baseUrl = "{{ asset('uploads/category') }}";
            // elem = state.element.value.toLowerCase();
            elem = $(state.element).attr("imageUrl");


            //elem = "cat";
            //  console.log((state.element));
            var $state = $(
                '<span><img src="' + elem +
                '" class="img-flag" /> ' + state.text + '</span>'
            );
            return $state;
        };

        function parnet_selected() {
            getAttr("sel_parent_category");
            getCats();
        }

        function getCats() {
            var id = $("#sel_parent_category").val();

            $('#sel_category')
                .empty()
                .append('<option value="">---</option>');
            $('#sel_category').val(null).trigger('change');

            if (id == "")
                return;


            $.ajax({
                url: "{{ url('dash/project/') }}/" + id + "/cats",
                dataType: 'json',
                type: "get",
            }).done(function(data) {
                //  $('#sel_category').empty().trigger("change");

                $('#sel_category').select2('data', null, false);


                $.map(data.results, function(item) {

                    //  var newOption = new Option(item.text, item.id, false, false);
                    newOption = '<option imageUrl="' + item.imageUrl + '" value="' + item.id + '">' +
                        item.text + '</option>';


                    $('#sel_category').append(newOption);
                });

                if (data.results.length > 0)
                    $('#sel_category').trigger('change');



            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: "{{ _i('No response from server') }}",
                    timeout: 2000,
                    killer: true
                }).show();
            });


        }
    </script>
@endpush
