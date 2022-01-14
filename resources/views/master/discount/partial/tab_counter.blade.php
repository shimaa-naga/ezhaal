<form action="{{ $action }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
    @if (isset($discount))
        {{ method_field('PUT') }}

    @else
        {{ method_field('POST') }}

    @endif
    @csrf
    <input type="hidden" name="frm" value="counter">
    <div class="form-group ">
        <div class="row">
            <label class="col-sm-2 col-form-label" for="title2">{{ _i('Title') }} </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title2" required=""
                       placeholder="{{ _i('Please Enter Discount Title') }}"
                       value="{{ isset($discount) ? $discount->title : '' }}">
            </div>
        </div>
    </div>
    <div class="form-group ">
        <div class="row">
            <label class="col-sm-2 col-form-label">{{ _i('Discount Type') }} </label>
            <div class="col-sm-4">
                <label class="">
                    {!! Form::radio('discountfor', App\Help\Constants\DiscountModule::PER_USER_OPERATIONS, isset($discount) ? $discount->module : '', ['required' => '']) !!}

                    {{ _i('Operations Number/User') }}
                </label>
                <label class="">
                    {!! Form::radio('discountfor', App\Help\Constants\DiscountModule::PER_USERS, isset($discount) ? $discount->module : '', ['required' => '']) !!}
                    {{-- <input type="radio" value="{{ App\Help\Constants\DiscountModule::PER_USERS }}" name="discountfor"> --}}
                    {{ _i('Selected Number of users') }}
                </label>
            </div>

            <label class="col-sm-2 col-form-label">{{ _i('Number') }} </label>
            <div class="col-sm-4">
                <input type="number" required="" class="form-control" name="counter" value="{{ isset($discount) ? $discount->times : '' }}" >
            </div>
        </div>
    </div>
    <div class="form-group ">
        <div class="row">
            <label class="col-sm-2 col-form-label" for="type2">{{ _i('Price Type') }} </label>
            <div class="col-sm-4">
                <label>
                    {!! Form::radio('type', 'perc', isset($discount) ? $discount->type : '', ['required' => '']) !!} {{ _i('Percentage') }}
                </label>
                <label>
                    {!! Form::radio('type', 'net', isset($discount) ? $discount->type : '', ['required' => '']) !!}{{ _i('Net') }}
                </label>
                {{-- <select class="form-control" name="type" id="type2" required="">
                    <option value="perc">{{ _i('Percentage') }}</option>
                    <option value="net">{{ _i('Net') }}</option>
                </select> --}}
            </div>

            <label class="col-sm-2 col-form-label" for="price">{{ _i('Price') }} </label>
            <div class="col-sm-4">
                <input type="number" step="0.1" class="form-control" name="price" id="price" required=""
                       placeholder="{{ _i('Please Enter Discount Price') }}"
                       value="{{ isset($discount) ? $discount->price : '' }}">
            </div>
        </div>
    </div>
    <div class="form-group ">
        <div class="row">
            <label class="col-sm-2 col-form-label" for="user_type2">{{ _i('For') }}</label>
            <div class="col-sm-4">
                @php
                    $selected = '';
                    if (isset($discount)) {
                        $selected = $discount->user_type;
                    }
                @endphp
                {!! Form::select('user_type', ['' => _i('All'), 'freelancer' => _i('Freelancers'), 'trustedfreelancer' => _i('Trusted Freelancer'), 'provider' => _i('Providers'), 'trustedprovider' => _i('Trusted Providers'), 'selected' => _i('Selected Users')], $selected, ['id' => 'user_type', 'onchange' => 'showSelected(this)', 'class' => 'form-control']) !!}
                {{-- <select class="form-control" name="user_type" id="user_type2" onchange="showSelected(this)">
                    <option selected value="">{{ _i('All') }}</option>
                    <option value="freelancer">{{ _i('Freelancers') }}</option>
                    <option value="trustedfreelancer">{{ _i('Trusted Freelancer') }}</option>
                    <option value="provider">{{ _i('Providers') }}</option>
                    <option value="trustedprovider">{{ _i('Trusted Providers') }}</option>
                    {{-- <option value="selectedUsers">{{ _i('Selected Users') }}</option>
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
                    {!! Form::radio('enabled', '0', (isset($discount) && $discount->enabled===false) ? true : '') !!}
                    {{ _i('Disabled') }}
                </label>
            </div>
        </div>
    </div>
    @if (!isset($discount) || count($discount->Transaction()->get()) == 0)
        <div class="form-group">
            <div class="col-lg-offset-2 ">
                <button type="submit" class="btn btn-primary col-lg-12">{{ 'Save' }}</button>
            </div>
        </div>
    @endif
</form>
