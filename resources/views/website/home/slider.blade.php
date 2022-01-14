<!--Sliders Section-->

<section>
    <div class="banner1">
        <div class="container-fuild">
            <!-- Carousel -->
            <div class="owl-carousel testimonial-owl-carousel2 slider">
                <!-- Place somewhere in the <body> of your page -->

                @foreach ($sliders as $slider)
                    <div class="item cover-image" data-image-src="">
                        <img alt="{{ $slider->title }}" src="{{ asset($slider->image) }}" width="100%">
                        <div class="header-text ">
                            <div class="col-md-12 text-center text-white">
                                <h1 class="mb-2">
                                    <a href="{{ $slider->url }}"> {{$slider->title }}
                                    </a>
                                </h1>
                                <h4>{{ $slider->description }}</h4>
                                <div>
                                    {{-- <a href="#" class="btn btn-primary">Sell Domain</a> --}}
                                    <a href="{{ url('dash/project/create') }}" class="btn btn-secondary">{{ _i('Buy') }}</a>
                                    <a href="{{ url('dash/service/create') }}" class="btn btn-info">{{ _i('Sell') }}</a>
                                </div>
                            </div>
                        </div><!-- /header-text -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--Sliders Section-->
