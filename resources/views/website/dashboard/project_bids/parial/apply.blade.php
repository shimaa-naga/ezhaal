@include("website.dashboard.project_bids.parial.project_info")
@auth('web')
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title"> {{ _i('Place your bid') }}</h3>
        </div>

        <div class="card-body">
            @if (!$disabled)
                @push('js')
                    <script>
                        function Calc(item) {
                            var price = parseFloat($(item).val());


                            //add discount
                            price = Math.ceil(price + ({{ $eqDiscount }}));


                            comm = Math.ceil(price - ({{ $eq }}));

                            $("#calc").val(comm);
                        }
                    </script>
                @endpush
                <form class="php-email-form form-horizontal tasi-form" method="post" enctype="multipart/form-data" action=""
                    data-parsley-validate="">
                    @csrf

                    <div class="form-group">
                        <textarea id="desc" rows="5" class="form-control" name="desc" required=""
                            placeholder="{{ _i('Project Description') }}">{{ old('desc') }}</textarea>
                    </div>

                    @php
                        $items = App\Models\Projects\ProjcategoryAttributes2::where('category_id', $category->id)
                            ->orderBy('sort')
                            ->get();
                        //    dd($items);
                    @endphp

                    @include("website.dashboard.project_bids.parial.attributes2",["items"=>$items])


                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-3">

                                <input type="number" min="10" id="budget" class="form-control" name="budget" required=""
                                    value="{{ old('budget') }}" placeholder="{{ _i('Cost') }}" onkeyup="Calc(this)"
                                    onchange="Calc(this)">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ _i('USD') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">

                                <input type="number" id="calc" class="form-control"
                                    placeholder="{{ _i('Your Profit') }}" readonly="">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ _i('USD') }}</span>
                                </div>
                            </div>
                        </div>

                        @if ($discount != null)
                            <div class="col-md-12">
                                <div class="input-group mb-3 alert alert-info ">

                                    <input type="hidden" name="discount_id" value="{{ $discount->id }}">
                                    {{ $discount->title }} : {{ _i('you will have') }}
                                    +{{ $discount->price }}{{ $discount->type == 'net' ? '' : '%' }}

                                </div>
                            </div>
                        @endif
                    </div>


                    <br />
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary col-lg-3">{{ _i('Submit') }} <i
                                class="fa fa-send"></i></button>
                    </div>
                </form>
            @endif


            @include("website.dashboard.project_bids.parial.bids_ajax")

        </div>
    </div>

@else
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title"> {{ _i('Place your bid') }}</h3>
        </div>

        <div class="card-body">
            <form class="php-email-form form-horizontal tasi-form" method="post" enctype="multipart/form-data" action=""
                data-parsley-validate="">
                @csrf

                <a class="btn btn-primary"
                    href="{{ url('login') }}?return={{ implode('/', request()->segments()) }}">{{ _i('Login') }}</a>
            </form>
            <p>
            </p>
            @include("website.dashboard.project_bids.parial.bids_ajax")

        </div>
    </div>
@endauth
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Message') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('dash/message/store') }}" method="POST" id='form_add' data-parsley-validate="">
                @csrf {{ method_field('POST') }}
                <input type="hidden" name="project_id" value="{{ $id }}">
                <input type="hidden" name="subject" value="{{ $project->title }}">

                <input type="hidden" name="to_id" id="to_id" value="">

                <div class="modal-body">
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <textarea name="msg" id="msg" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="md-close" class="btn btn-secondary"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ _i('Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(function() {
            $('#exampleModal').on('shown.bs.modal', function(event) {
                var triggerElement = $(event.relatedTarget);
                $('#to_id').val($(triggerElement).data("user_id"));

            })
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
                        if (response == 'SUCCESS') {
                            $('#md-close').click();
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Sent Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();

                            $('#msg').val("");
                        }
                    }
                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: "{{ _i('No response from server') }}",
                        timeout: 2000,
                        killer: true
                    }).show();
                });
            });
        });

    </script>
@endpush
