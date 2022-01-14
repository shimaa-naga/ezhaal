<div class="card">
    <div class="card-header">
        <div class="card-title">
            {{_i("On Request Transactions")}}
            <h5> {{ _i('Send notification to') }} </h5>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('master/settings/onrequest') }}" class="form-horizontal"
              data-parsley-validate="">
            @csrf
            <div class="form-group">
                {{-- <label for="" class="col-sm-4 col-form-label">{{ _i('Select Group') }}</label> --}}
                <div class="col-sm-12">
                    {!! Form::select(
    'role',
    Spatie\Permission\Models\Role::all()->prepend('', '')->pluck('name', 'name'),
    \App\Help\Settings::getOnrequestGroup(),
    ['class' => 'form-control'],
) !!}
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-info col-sm-12">{{ _i('Save') }}</button>
            </div>
        </form>
    </div>
</div>

