@extends('website.dashboard.index_inner', ['title' => _i('Open a ticket')])

@section('content')
    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Open a ticket')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Open a ticket')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb-->

    <!--User Dashboard-->
    <section class="sptb">
        <div class="container">
            <div class="row">

                @include("website.dashboard.complaints.complaint_nav")
                <div class="col-xl-9 col-lg-9 col-md-9">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('Open a ticket')}}</h3>
                        </div>

                        <div class="card-body">
                            @if (session('msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ _i('Error') }}!</strong> {{ session('msg') }}.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="member align-items-start">
                                <p class="">
                                    {{_i('If you cannot find a solution to your problem in the knowledge base articles, you can open a ticket by choosing the appropriate section below')}}:
                                </p>
                                <p><strong>{{_i('Categories')}} ::</strong></p>
                                <br>

                                <form method="POST" action="{{ route('website.complaints.open_ticket') }}" data-parsley-validate="" >
                                    @csrf
                                    <input type="hidden" name="next_value" value="1">
                                    @foreach($complaint_types as $type)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="complaint_type" value="{{$type->type_id}}" id="flexRadioDefault_{{$type->type_id}}" required=""
                                                   data-parsley-required-message="{{_i('Please select the section most appropriate to the subject of the ticket')}}">
                                            <label class="form-check-label" for="flexRadioDefault_{{$type->type_id}}">
                                                {{$type->title}}
                                            </label>
                                        </div>
                                    @endforeach
                                    <br>
                                    <button type="submit" class="btn btn-primary">{{_i('Next')}} &raquo;</button>
                                </form>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->

    <!-- Content section End -->
@endsection



