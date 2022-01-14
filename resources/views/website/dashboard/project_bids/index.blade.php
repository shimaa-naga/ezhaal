<?php $category = $project->Category()->first();
$title = $category->DataWithLang()->title;
?>
@extends('website.layout.index',["form"=>true,"title"=> $project->title,"header_title"=>['<a href="'.url("projects").'">All</a>','<a href="'.url('projects/cat/').'/'. $title.'">'.$title.'</a>']])


@section('content')
    <div class="row">

        @include("website.dashboard.project_bids.parial.info")


        <div class="col-xl-9 col-lg-12 col-md-12">


            {{-- @include("website.dashboard.project_bids.parial.details",["category"=>$category]) --}}
            @include("website.dashboard.project_bids.parial.apply",["category"=>$category])

            {{-- @include("website.dashboard.project_bids.parial.bids") --}}


            {{-- <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @include("website.dashboard.project_bids.parial.apply",["category"=>$category])

                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        @include("website.dashboard.project_bids.parial.bids")

                    </div>

                </div> --}}






        </div>
    </div>

    <!-- Content section End -->
@endsection

@push('js')
    <script src="{{ asset('custom/jquery.MultiFile.min.js') }}"></script>
@endpush
