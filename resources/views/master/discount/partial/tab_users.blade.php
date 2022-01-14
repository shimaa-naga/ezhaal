<form action="{{$action }}" method="POST" name="frm_user" data-parsley-validate=""
    enctype="multipart/form-data">
    @csrf
    @if (isset($discount))
        {{ method_field('PUT') }}

    @else
        {{ method_field('POST') }}

    @endif
    <input type="hidden" name="frm" value="user">
    <div class="form-group ">
        <div class="row">
        <label class="col-sm-2 col-form-label" for="user">{{ _i('User') }}
        </label>

        <div class="form-group col-sm-4">
            {!! Form::select(
    'user',
    \App\User::where('guard', 'web')->get()->pluck('NameWithEmail', 'id'),
    $selected_users,
    ['style' => 'width: 100%', 'id' => 'sel_user',"class"=>"form-control js-example-basic-single"],
) !!}

        </div>
        <label class="col-sm-2 col-form-label" for="times">{{ _i('how many times') }} </label>
        <div class="col-sm-4">
            <input type="number" value="1" class="form-control" name="times" required=""
                value="{{ isset($discount) ? $discount->times : '' }}">
        </div>
        </div>
    </div>
    <div class="form-group ">
        <div class="row">
        <label class="col-sm-2 col-form-label" for="type3">{{ _i('Price Type') }} </label>
        <div class="col-sm-4">
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
    @if (!isset($discount) || count($discount->Transaction()->get()) == 0)
    <div class="form-group">
        <div class="col-lg-offset-2 ">
            <button type="submit" class="btn btn-primary col-lg-12">{{ 'Save User Discount' }}</button>
        </div>
    </div>
    @endif
</form>
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('master/assets/select2/css/select2.min.css') }}" />
@endpush
@push('js')
    <script type="text/javascript" src="{{ asset('master/assets/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
        });

    </script>

@endpush
