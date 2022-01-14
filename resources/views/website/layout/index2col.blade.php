{{--@extends('website.layout.index')--}}
@extends('website.dashboard.index_inner')
@section('content')
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <div class="row gy-4">
                @if (session('success'))

                        <div class="alert alert-success alert-block col-sm-12 ">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <h6>
                                <i class="fa fa-ok-sign"></i>
                                {{ _i('Success') }}!
                            </h6>
                            <p>{{ session('success') }}</p>
                        </div>

                @endif
                @if (session('error'))

                        <div class="alert alert-danger  alert-block  col-sm-12 ">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <h6>
                                <i class="fa fa-ok-sign"></i>
                                {{ _i('Error') }}!
                            </h6>
                            <p>{{ session('error') }}</p>
                        </div>

                @endif

                @if ($errors->all())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-lg-3">
                    <div class="<?= (isset($nav)  && $nav == true) ? '' : 'portfolio-info' ?>">
                        @yield('col1')
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="<?= (isset($form)  && $form == true) ? '' : 'portfolio-info' ?>">
                            @yield('col2')
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
