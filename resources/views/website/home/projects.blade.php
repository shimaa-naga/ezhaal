<section class="sptb">
    <div class="container">
        <div class="section-title center-block text-center">
            <h1>{{ _i('Latest Projects') }}</h1>
{{--            <p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>--}}
        </div>
        <div id="myCarousel1" class="owl-carousel owl-carousel-icons2">
            @forelse($projects as $project)

            {{-- <div class="item">
                <div class="card mb-0">
                    <div class="card-body">
                        <img src="../assets/images/faces/male/1.jpg" alt="img" class=" avatar avatar-xxl brround mx-auto">
                        <div class="item-card2">
                            <div class="item-card2-desc text-center">
                                <div class="item-card2-text mt-3">
                                    <a href="books-authorlist.html" class="text-dark"><h4 class="font-weight-bold">Sid Quebedeaux</h4></a>
                                </div>
                                <p class="">25,635 Published Books</p>
                                <a href="books-authorlist.html" class="btn btn-white btn-sm ">View Books</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div> --}}

            <div class="item">
                <div class="card mb-0">
                    {{-- <div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-danger"><i class="fa fa-bolt"></i></span></div> --}}

                    <div class="card-body">
                        <img src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}" alt="img" class=" avatar avatar-xxl brround mx-auto">

                        <div class="item-card2">


                            <div class="item-card2-desc">
                                <small class="">{{_i("By")}}:  {{ $project->ByUser['name'] . ' ' . $project->ByUser['last_name'] }}</small>
                                <p>
                                <i class="fa fa-clock-o"></i>
                                {{ \Carbon\Carbon::parse($project['created_at'])->diffforhumans() }}
                                </p>
                                <div class="item-card2-text mt-1">
                                    <a href="{{ url('projects/cat/')}}/{{ $project->Category()->first()->DataWithLang()->title}}" class="text-dark"><h4 class="font-weight-bold">{{ $project->title}}</h4></a>
                                </div>
                                <a href="{{url('project')}}/{{$project->id}}/{{$project->title}}" class="text-white badge badge-{{$project->type=='project'? 'danger' : 'primary'}}"> {{$project->Category()->first()->DataWithLang()->title }}</a>

                                <p class="">{{ Illuminate\Support\Str::words(strip_tags($project->description), 30, '..') }}</p>
                                {{-- <h2>$15 <span class="fs-16"><del>$25</del></span></h2> --}}
                                {{-- <div class="item-card2-rating mb-0">
                                    <div class="rating-stars d-inline-flex">
                                        <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
                                        <div class="rating-stars-container">
                                            <div class="rating-star sm">
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="rating-star sm">
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="rating-star sm">
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="rating-star sm">
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="rating-star sm">
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div> (78)
                                    </div>
                                </div> --}}
                                <a href="{{url('project')}}/{{$project->id}}/{{$project->title}}" class="btn btn-primary text-white mt-3">{{_i("GO")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            @empty
            <a href="{{ route('website.projects.index') }}"
                class="alerts-title">{{ _i('There are no projects to display') }}.</a>
            @endforelse

        </div>
    </div>
</section>









