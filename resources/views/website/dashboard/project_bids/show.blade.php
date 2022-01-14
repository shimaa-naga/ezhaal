@extends('website.dashboard.index_inner',["form"=>true,"title"=> $project->title,"header_title"=>["<a
    href='".url("dash/project")."'>"._i("My Deals")."</a>",'<a
    href="'.url('dash/project/').'/'. $project->id.'">'.$project->title.'</a>']])

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
    <div class="container">
        <div class="row">

            @include("website.dashboard.project_bids.parial.info")

            <div class="col-xl-9 col-lg-12 col-md-12">
                <div class="card mb-0">
                    <div class="card-header">
                        <h3 class="card-title">{{ $project->title }}</h3>
                    </div>

                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">{{ _i('Details') }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">{{ _i('Messages') }}</a>
                            </li>

                            @if ($project->Status()->first()->title == App\Help\Constants\ProjectStatus::ASSIGNED || $project->Status()->first()->title == App\Help\Constants\ProjectStatus::CLOSED || $project->Status()->first()->title == App\Help\Constants\ProjectStatus::COMPLETED)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="state-tab" data-toggle="tab" href="#state" role="tab"
                                        aria-controls="state" aria-selected="false">{{ _i('Status') }}</a>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @include("website.dashboard.project_bids.parial.bid_item",["item" => $bid])



                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <p class="pull-right">
                                    <a href="#" data-user_id="{{ $bid->freelancer()->id }}" data-toggle='modal'
                                        data-target='#exampleModal' class="btn btn-default"
                                        title="{{ _i('Message') }}"><i
                                            class="fa fa-envelope"></i>{{ _i('New Message') }}</a>
                                </p>
                                <p>&nbsp;
                                </p>
                                @forelse ($history as $message)
                                    @include("website.dashboard.messages.partial.show",["message"=>$message])
                                @empty
                                    {{ _i('No messages.') }}
                                @endforelse


                            </div>
                            @if ($project->Status()->first()->title == App\Help\Constants\ProjectStatus::ASSIGNED || $project->Status()->first()->title == App\Help\Constants\ProjectStatus::CLOSED || $project->Status()->first()->title == App\Help\Constants\ProjectStatus::COMPLETED)
                                <div class="tab-pane fade" id="state" role="tabpanel" aria-labelledby="state-tab">
                                    <p>
                                    </p>
                                    @include("website.dashboard.project_bids.show.timeline")
                                    @if ($project->Status()->first()->title != App\Help\Constants\ProjectStatus::CLOSED)
                                        <form action="{{ url('dash/bid_work/close') }}/{{ $bid->id }}"
                                            method="POST">
                                            @csrf {{ method_field('POST') }}
                                            <div class=" row">

                                                <button type="submit"
                                                    class="btn btn-danger">{{ _i('Close Project') }}</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>




                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ _i('Message') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ url('dash/message/store') }}" method="POST" id='form_add'
                                        data-parsley-validate="">
                                        @csrf {{ method_field('POST') }}
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        <input type="hidden" name="subject" value="{{ $project->title }}">

                                        <input type="hidden" name="to_id" id="to_id" value="">

                                        <div class="modal-body">
                                            <div class="form-group row">

                                                <div class="col-sm-12">
                                                    <textarea name="msg" id="msg" class="form-control"
                                                        required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="md-close" class="btn btn-secondary"
                                                data-dismiss="modal">{{ _i('Close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ _i('Send') }}</button>
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



    <!-- Content section End -->
@endsection



@push('js')
    <script>
        $(function() {
            $('#exampleModal').on('shown.bs.modal', function(event) {
                var triggerElement = $(event.relatedTarget);
                $('#to_id').val($(triggerElement).data("user_id"));

            })
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('action');

                $.ajax({

                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == 'SUCCESS') {
                            $('#md-close').click();
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Sent Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();

                            $('#msg').val("");
                        }
                    }
                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: "{{ _i('No response from server') }}",
                        timeout: 2000,
                        killer: true
                    }).show();
                });
            });
        });
    </script>
@endpush
