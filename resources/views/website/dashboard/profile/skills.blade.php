@extends('website.dashboard.index_inner', ['title' => _i('Skills')])

@section('content')


    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Skills')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Skills')}}</li>
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

                @include('website.dashboard.profile.profile_nav')

                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('Skills')}}</h3>
                        </div>

                            <div class="card-body">

                                <form  id="form_comment" method="POST" action="{{ route('website.profile.save_skills') }}" data-parsley-validate="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">{{_i("Skills")}} : </label>
                                        <select class="js-example-basic-multiple form-control" multiple="multiple" name="skills[]" >
                                            <option value="">...</option>
                                            @foreach (App\Help\Skills::GetAll() as $item)
                                                <option value="{{$item->skill_id}}"
                                                @if($user_skills!=null) @foreach($user_skills as $skill){{$skill->skill_id==$item->skill_id?"selected":""}} @endforeach @endif
                                                >{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary col-lg-3">{{_i('Save')}} <i class="fa fa-save"></i></button>
                                </form>

                            </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->

    <!-- Content section End -->
@endsection
@push("css")
    <link rel="stylesheet" type="text/css" href="{{asset('custom/select2/css/select2.min.css')}}" />
@endpush
@push('js')
    <script type="text/javascript" src="{{asset('custom/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".js-example-basic-multiple").select2();
        });
    </script>
@endpush
