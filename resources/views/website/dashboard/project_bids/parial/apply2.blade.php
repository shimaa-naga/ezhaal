<div class="">



    @php

        $items = App\Models\Projects\ProjcategoryAttributes::where('category_id', $category->id)
            ->orderBy('sort')
            ->get();
    @endphp
    @if (count($items) > 0)
        <div class="table-responsive">
            <table class="table row table-borderless w-100 m-0 text-nowrap ">
                <tbody class="col-lg-12 col-xl-6 p-0">
ffffffffffffffffff
                    @include('website.dashboard.project.partial.attributes_shw',["items"=> $items,"project"
                    =>$project])

                </tbody>
            </table>
        </div>

    @endif
    <?php $selected_list = $project
        ->Skills()
        ->get()
        ->pluck('id')
        ->toArray(); ?>
    @if (count($selected_list) > 0)
        <label for="">{{ _i('Skills') }}</label>
        @foreach (App\Help\Skills::GetAll() as $item)
            <?php $selected = in_array($item->skill_id, $selected_list); ?>
            @if ($selected)
                <span class="badge badge-pill badge-secondary">{{ $item->title }}</span>

            @endif

        @endforeach

    @endif
    @if (count($project->Attachments()->get()) > 0)

        @include("website.dashboard.project.partial.attach",["project" => $project,"show" => true])

    @endif
</div>


@auth('web')

    <div class=" ">
        <div class="">
            <h3 class="card-title"> {{ _i('Place your bid') }}</h3>
        </div>

        <div class="">
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

                                <input type="number" id="calc" class="form-control" placeholder="{{ _i('Your Profit') }}"
                                    readonly="">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ _i('USD') }}</span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="input-group mb-3 ">
                                <input type="number" min="1" id="duration" class="form-control" name="duration" required=""
                                    value="{{ old('duration') }}" placeholder="{{ _i('Duration') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ _i('Days') }}</span>
                                </div>
                            </div>
                        </div> --}}
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
                    {{-- <input type="file" name="attach[]" class="form-control multi {
                                                                            accept:'gif|jpg',
                                                                            max:3,
                                                                            STRING:{
                                                                              remove:'Remover',
                                                                              selected:'Selecionado: $file',
                                                                              denied:'{{ _i('Invalid type file') }} $ext!',
                                                                              duplicate:'{{ _i('File already selected') }}:\n$file!'
                                                                            }
                                                                          }" /> --}}

                    <br />
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary col-lg-3">{{ _i('Submit') }} <i
                                class="fa fa-send"></i></button>
                    </div>
                </form>
            @endif

            <p>
            </p>
            @include("website.dashboard.project_bids.parial.bids_ajax")

        </div>
    </div>

@else
    <div class="">
        <div class="">
            <h3 class="card-title"> {{ _i('Place your bid') }}</h3>
        </div>

        <div class="">
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
