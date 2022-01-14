<div class="col-lg-8">
    <section class="panel">
        <div class="panel-body">
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">
                    {{ _i('Payment status') }} :
                </label>
                <div class="col-sm-10">
                    {{ $bid->payment_status }}
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">
                    {{ _i('Payment Date') }} :
                </label>
                <div class="col-sm-10">
                    {{ $requestObj->updated_at }}
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">
                    {{ _i('Amount') }} :
                </label>
                <div class="col-sm-10">
                    {{ $requestObj->price }}
                </div>
            </div>

        </div>
    </section>
</div>
<div class="col-lg-4">
    <section class="panel">
        <div class="panel-body">
            <img style="width: 100%" src="{{route('downloadTransRequest',["id"=> $requestObj->id])}}" />
        </div>
    </section>
</div>
