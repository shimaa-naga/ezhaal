
    <section class="card">
        <div class="card-header">
            {{ _i('Transaction') }}
        </div>
        <div class="card-body">
            <div class=" row">
                <label for="" class="col-sm-2 font-weight-semibold ">
                    {{ _i('Transaction Number') }} :
                </label>
                <div class="col-sm-4">
                    {{ $trans->trans_number }}
                </div>

                <label for="" class="col-sm-2 font-weight-semibold ">
                    {{ _i('Confirm Number') }} :
                </label>
                <div class="col-sm-4">
                    {{ $trans->confirm_number }}
                </div>
            </div>
            <div class="row">
                <label for="" class="col-sm-2 font-weight-semibold ">
                    {{ _i('Date') }} :
                </label>
                <div class="col-sm-4">
                    {{    \Carbon\Carbon::parse($trans->created_at)->format("D d-m-Y H:i:s")}}
                </div>

                <label for="" class="col-sm-2 font-weight-semibold ">
                    {{ _i('By') }} :
                </label>
                <div class="col-sm-4">
                    {{ $trans->User->name }}  {{ $trans->User->last_name }}
                    < {{ $trans->User->email }}>
                </div>
            </div>

            <div class="row">
                <label for="" class="col-sm-2 font-weight-semibold ">
                    {{ _i('Payment status') }} :
                </label>
                <div class="col-sm-4">
                    {{ $trans->status }}
                </div>

                <label for="" class="col-sm-2 font-weight-semibold ">
                    {{ _i('Payment Method') }} :
                </label>
                <div class="col-sm-4">
                    {{ $trans->Method->title }}
                </div>
            </div>
            <div class="row bg-secondary text-white">
                <label class="col-sm-3  ">
                    {{ _i('Total') }} :
                </label>
                <label class="col-sm-3 ">
                    {{ _i('Commission') }} :
                </label>
                @if ($trans->Discount != null)
                    <label class="col-sm-3 ">
                        {{ $trans->Discount->title }} :
                    </label>
                @endif
                <label class="col-sm-3 ">
                    {{ _i('Amount') }} :
                </label>
            </div>
            <div class="row bg-teal">
                <div class="col-sm-3">
                    {{ $trans->total }} {{ $trans->currency }}
                </div>
                <div class="col-sm-3">
                    {{ $trans->commission }}
                </div>
                @if ($trans->Discount != null)

                    <div class="col-sm-3">
                        {{ $trans->Discount->type == 'net' ? '+' : '%' }} {{ $trans->Discount->price }}
                    </div>
                @endif
                <div class="col-sm-3">
                    {{ $trans->user_amount }}
                </div>
            </div>

        </div>
    </section>

