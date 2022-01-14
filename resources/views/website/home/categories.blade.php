<!--Categories-->
<section class="sptb bg-white">
    <div class="container">
        <div class="section-title center-block text-center">
            <h1>{{ $type == 'project' ? _i('Projects') : '' }}
                {{ $type == 'service' ? _i('Services') : '' }}</h1>
            <p>{{ $type == 'project' ? _i('Show categories of projects') : '' }}
                {{ $type == 'service' ? _i('Show categories of services') : '' }}
                .
            </p>
        </div>
        <div class="item-all-cat center-block text-center books-categories" id="container2">
            <div class="row">
@php
$list =\App\Help\Utility::getCategoriesWithType($type);
@endphp
                @foreach ($list as $item)
                    <div class="col-lg-3 col-md-4">
                        <div class="item-all-card text-dark text-center p-4 bg-white">
                            <a href="projects/cat/{{ $item['title'] }}"></a>
                            <div class="item-all-text">
                                <h5 class="mb-0 text-body font-weight-bold">{{ $item['title'] }}</h5>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</section>
<!--/Categories-->
