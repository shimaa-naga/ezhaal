
<!--Categories-->
<section class="sptb "  id="services">
    <div class="container">
        <div class="section-title center-block text-center">
            <h1>{{ _i('How it works') }}</h1>
            <p>{{_i('The Ezhaal platform is a link between bidders and beneficiaries. It also provides an online ordering service.')}}?</p>
        </div>
        <div class="item-all-cat center-block text-center">
            <div class="row">
                @foreach(\App\Help\Utility::workMethod() as $method)
                    <div class="col-lg-2 col-md-4">
                        <div class="item-all-card text-dark text-center">
                            <a href="business-list.html"></a>
                            <div class="iteam-all-icon">
                                <i class="{{$method->icon}} imag-service"></i>

                            </div>
                            <div class="item-all-text mt-3">
                                <h5 class="mb-0 text-body">{{ $method->Lang()->title }}</h5>
                                <p>
                                    {{ $method->Lang()->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

{{--            <div class="mt-4">--}}
{{--                <a href="#" class="btn btn-primary">View More</a>--}}
{{--            </div>--}}
        </div>
    </div>
</section>
<!--/Categories-->
