@extends('website.layout.index', ['title' => _i('Profile'),'header_title' => _i('Profile')])

@section('content')
    <section id="portfolio-details" class="portfolio-details">

    <div class="container">
        <div class="main-body">


            <div class="row gutters-sm">

                @include('website.dashboard.profile.company.profile_nav')

                <div class="col-lg-9 col-md-12 col-xs-12">
                    <div id="team" class="team">
                        <div class="container">
                            <div class="row">

                                <div class="member   ">
                                    <h3 class="alerts-title">{{_i('Profile')}}</h3>
                                    <div class="card mb-3">
                                        <form  method="POST" action="{{ route('website.profile.save') }}" data-parsley-validate="" enctype="multipart/form-data">
                                            @csrf
                                        <div class="card-body">


                                            <div class="row">
                                                <div class="col ">
                                                    <label>{{_i('About Institution')}} :</label>
                                                    <textarea class="form-control" rows="5" name="about" placeholder="{{_i('Please write yhere')}}...">{{$user_info->about??""}}</textarea>
                                                </div>
                                            </div><hr>


                                            <button type="submit" class="btn btn-primary col-lg-3">{{_i('Save')}} <i class="fa fa-save"></i></button>
                                        </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    </section>

    <!-- Content section End -->
@endsection
