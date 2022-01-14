<?php $category = $project->Category()->first();

?>

@extends('website.dashboard.index_inner',["form"=>true,"title"=> $project->title,"header_title"=> "<a
    href='".url("dash/project")."'>"._i("My Deals")."</a>"])

@section('content')
    <!--Breadcrumb-->

    <section>
        <div class="bannerimg cover-image bg-background3"
            data-image-src="{{ asset('website2/assets/images/banners/banner2.jpg') }}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{ $project->title }}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{ _i('Home') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $project->title }}</li>
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
                <div class="col-xl-12 col-lg-12 col-md-12">

                    @include("website.dashboard.project_bids.parial.project_info")

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ _i('Bids') }}</h3>
                        </div>

                        <div class="card-body">
                            @include("website.dashboard.project_bids.parial.bids_ajax")



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->

    <!-- Content section End -->
@endsection

@push('js')
    <script src="{{ asset('custom/jquery.MultiFile.min.js') }}"></script>
@endpush
