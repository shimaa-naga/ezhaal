<form action="{{ $action }}" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
    @if (isset($discount))
        {{ method_field('PUT') }}

    @else
        {{ method_field('POST') }}

    @endif
    @csrf
    <input type="hidden" name="frm" value="duration">
        <div class="form-group ">
            <div class="row">
        <label class="col-sm-2 col-form-label" for="title">{{ _i('Title') }} </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" required=""
                value="{{ isset($discount) ? $discount->title : '' }}"
                placeholder="{{ _i('Please Enter Discount Title') }}">
        </div>
            </div>
    </div>
        <div class="form-group ">
            <div class="row">
        <label class="col-sm-2 col-form-label" for="from_date">{{ _i('Start Date') }} </label>
        <div class="col-sm-4">
            {{-- <input type="date" required="" class="form-control" name="from_date" id="from_date" placeholder="YYYY-MM-DD" > --}}
            <div class="iconic-input right">
                <i class="fa fa-calendar"></i>
                <input required="" name="from_date" id="from_date" placeholder="DD-MM-YYYY"
                    class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
                    value="{{ isset($discount) ? $discount->fromDate : '' }}" />
            </div>
        </div>


        <label class="col-sm-2 col-form-label" for="to_date">{{ _i('End Date') }} </label>
        <div class="col-sm-4">
            {{-- <input type="date" class="form-control" name="to_date" id="to_date" placeholder="YYYY-MM-DD" required=""
                data-inputmask="'alias': 'yyyy-mm-dd'" data-mask=""> --}}
            <div class="iconic-input right">
                <i class="fa fa-calendar"></i>
                <input required="" name="to_date" id="to_date" placeholder="DD-MM-YYYY"
                    data-parsley-date_gte="#from_date"
                    class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"
                    value="{{ isset($discount) ? $discount->toDate : '' }}" />
            </div>
        </div>
            </div>
    </div>
        <div class="form-group ">
            <div class="row">
        <label class="col-sm-2 col-form-label" for="type1">{{ _i('Price Type') }} </label>
        <div class="col-sm-4">
            {{-- <label>
                <input type="radio" name="type" value="perc" required> {{ _i('Percentage') }}
            </label>
            <label>
                <input type="radio" name="type" value="net"> {{ _i('Net') }}
            </label> --}}
            <label>
                {!! Form::radio('type', 'perc', isset($discount) ? $discount->type : '', ['required' => '']) !!} {{ _i('Percentage') }}
            </label>
            <label>
                {!! Form::radio('type', 'net', isset($discount) ? $discount->type : '', ['required' => '']) !!} {{ _i('Net') }}
            </label>

        </div>

        <label class="col-sm-2 col-form-label" for="price">{{ _i('Price') }} </label>
        <div class="col-sm-4">
            <input type="number" step="0.1" class="form-control" name="price" required=""
                placeholder="{{ _i('Please Enter Discount Price') }}"
                value="{{ isset($discount) ? $discount->price : '' }}">
        </div>
    </div>
        </div>
        <div class="form-group ">
            <div class="row">
        <label class="col-sm-2 col-form-label" for="user_type">{{ _i('For') }}</label>
        <div class="col-sm-4">
            @php
                $selected = '';
                if (isset($discount)) {
                    $selected = $discount->user_type;
                }
            @endphp
            {!! Form::select('user_type', ['' => _i('All'), 'freelancer' => _i('Freelancers'), 'trustedfreelancer' => _i('Trusted Freelancer'), 'provider' => _i('Providers'), 'trustedprovider' => _i('Trusted Providers'), 'selected' => _i('Selected Users')], $selected, ['id' => 'user_type', 'onchange' => 'showSelected(this)', 'class' => 'form-control']) !!}
            {{-- <select class="form-control" name="user_type" id="user_type" onchange="showSelected(this)">
                <option selected value="">{{ _i('All') }}</option>
                <option value="freelancer">{{ _i('Freelancers') }}</option>
                <option value="trustedfreelancer">{{ _i('Trusted Freelancer') }}</option>
                <option value="provider">{{ _i('Providers') }}</option>
                <option value="trustedprovider">{{ _i('Trusted Providers') }}</option>
                <option value="selected">{{ _i('Selected Users') }}</option>

            </select> --}}
        </div>

        <label class="col-sm-2 col-form-label" for="code">{{ _i('Status') }} </label>
        <div class="col-sm-4">
            <label class="">

                {{-- <input type="radio" value="1" name="enabled"> --}}
                {!! Form::radio('enabled', '1', (isset($discount) && $discount->enabled===true) ? "1" : '', ['required' => '']) !!}
                {{ _i('Enabled') }}

            </label>
            <label class="">
                {{-- <input type="radio" value="0" name="enabled" checked> --}}
                {!! Form::radio('enabled', '0', (isset($discount) && $discount->enabled===false) ? '1' : '') !!}
                {{ _i('Disabled') }}
            </label>
        </div>
            </div>
    </div>
        <div class="form-group ">
            <div class="row last" style="@if (!(isset($discount) && $selected=='selected' )) display: none @endif" id="div_users">
{{--    <div class="form-group last row" style="@if (!(isset($discount) && $selected=='selected' )) display: none @endif" id="div_users">--}}
        <label class="control-label col-md-2">{{ _i('Selected Users') }}</label>
        <div class="col-md-9">
            <select name="users" class="multi-select" multiple="" id="my_multi_select3">
                @foreach (\App\User::where('guard', 'web')->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    </div>

    @if (!isset($discount) || count($discount->Transaction()->get()) == 0)
        <div class="form-group">
            <div class="col-lg-offset-2 ">
                <button type="submit" class="btn btn-primary col-lg-12">{{ 'Save Duration Discount' }}</button>
            </div>
        </div>
    @endif
</form>

@push('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('master/assets/bootstrap-datetimepicker/css/datetimepicker.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('master/assets/jquery-multi-select/css/multi-select.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('master/assets/bootstrap-datepicker/css/datepicker.css') }}" />
@endpush
@push('js')
    <script type="text/javascript" src="{{ asset('master/assets/jquery-multi-select/js/jquery.multi-select.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('master/assets/jquery-multi-select/js/jquery.quicksearch.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('master/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}">
    </script>
    <script type="text/javascript">
        function showSelected(obj) {
            if ($(obj).val() == "selected")
                $("#div_users").show();
            else {
                $("#div_users").hide();
                $('#my_multi_select3').multiSelect('deselect_all');
            }
        }
        $(function() {
            window.Parsley
                .addValidator('date_gte', {
                    validateString: function(_value, from, parsleyInstance) {
                        var arr = _value.split("-");
                        var t = new Date(arr[2] + " " + arr[1] + " " + arr[0]);
                        var arr = $(from).val().split("-");
                        var f = new Date(arr[2] + " " + arr[1] + " " + arr[0]);
                        return (f <= t);
                    },
                    messages: {
                        en: 'This value should be greeter than of %s',

                    }
                });
            $('.default-date-picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
            $('#my_multi_select3').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function(values) {
                    this.qs1.cache();
                    this.qs2.cache();
                    input = $('<input name="selectedusers[]" type="hidden" value="' + values +
                        '" id="input' + values + '">');
                    $("#form_add").append(input);
                },
                afterDeselect: function(values) {
                    this.qs1.cache();
                    this.qs2.cache();
                    $('#input' + values).remove();
                },


            });

        });

        @if ($selected == 'selected')
            @php
                $arr = $discount
                    ->Users()
                    ->get()
                    ->pluck('id');
            @endphp
            $(function(){
            @foreach ($arr as $id)
                $("#{{ $id }}-selectable").click();

            @endforeach
            })


        @endif

    </script>
@endpush
