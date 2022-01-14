@extends('website.layout.index',["form"=>true,"title"=> $project->title,"header_title"=>["<a
    href='".url("dash/bids/my")."'>"._i("My Bids")."</a>",$project->title]])

@section('content')

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true">{{ _i('Details') }}</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">{{ _i('Messages') }}</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" id="state-tab" data-toggle="tab" href="#state" role="tab" aria-controls="state"
                aria-selected="false">{{ _i('Status') }}</a>
        </li>
        @if ($bid->Status()->title == App\Help\Constants\BidStatus::ACCEPTED || $bid->Status()->title == App\Help\Constants\BidStatus::COMPLETED )
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="close-tab" data-toggle="tab" href="#close" role="tab" aria-controls="close"
                    aria-selected="false">{{ _i('Complete') }}</a>
            </li>
        @endif

    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="team">
                <div class="member d-flex align-bids-start">
                    <div class="member-info">

                        <img class="rounded-circle float-left" width="50" height="50"
                            src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}">{{ $project->owner()->name }}
                        <i title="{{ _i('Created') }}" class="fa fa-clock-o"> </i>
                        {{ Carbon\Carbon::parse($bid->created_at)->diffforhumans() }}
                        <p class="text-muted font-size-sm">
                            {{ $project->owner()->country() != null ? $project->owner()->country()['title'] : '' }},
                            {{ $project->owner()->city() != null ? $project->owner()->city()['title'] : '' }}</p>




                        <p>
                        </p>
                        <div class="row">
                            <div class="col-sm bg-light">
                                {{ _i('Cost') }} :
                                <i title="{{ _i('Cost') }}" class="">
                                    {{ $bid->priceAfter }} {{ \App\Help\Settings::getCurrency() }}</i>
                            </div>
                            <div class="col-sm bg-light">
                                <i title="{{ _i('Duration') }}"></i>{{ _i('Duration') }} : {{ $bid->duration }}
                                {{ _i('days') }}

                            </div>

                        </div>
                        <p>
                            {!! nl2br(strip_tags($project->description)) !!}
                        </p>
                        <p>
                            @if (count($bid->Attachments()->get()) > 0)

                                    @include("website.dashboard.project.partial.attach",["project" => $project,"show" =>
                                    true])

                            @endif
                        </p>
                        @if ($bid->Status()->title != App\Help\Constants\BidStatus::CLOSED)

                            <div class="social">

                                <a href="#" data-user_id="{{ $bid->freelancer()->id }}" data-toggle='modal'
                                    data-target='#exampleModal' class="msg" title="{{ _i('Message') }}"><i
                                        class="fa fa-envelope"></i></a>
                                &nbsp;


                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p class="pull-right">
                <a href="#" data-user_id="{{ $bid->freelancer()->id }}" data-toggle='modal' data-target='#exampleModal'
                    class="btn btn-default" title="{{ _i('Message') }}"><i
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

        <div class="tab-pane fade" id="state" role="tabpanel" aria-labelledby="state-tab">
            <p>
            </p>
            @include("website.dashboard.project_bids.show.timeline")
        </div>
        @if ($bid->Status()->title == App\Help\Constants\BidStatus::ACCEPTED  || $bid->Status()->title == App\Help\Constants\BidStatus::COMPLETED)

            <div class="tab-pane fade" id="close" role="tabpanel" aria-labelledby="close-tab">
                <p></p>
                @include("website.dashboard.project_bids.my.single.index")
            </div>
        @endif
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _i('Message') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('dash/message/store') }}" method="POST" id='form_add' data-parsley-validate="">
                    @csrf {{ method_field('POST') }}
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="subject" value="{{ $project->title }}">

                    <input type="hidden" name="to_id" id="to_id" value="">

                    <div class="modal-body">
                        <div class="form-group row">

                            <div class="col-sm-12">
                                <textarea name="msg" id="msg" class="form-control" required></textarea>
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


@endsection


@push('js')
    <script>
        $(function() {
            $('#exampleModal').on('shown.bs.modal', function(event) {
                var triggerElement = $(event.relatedTarget);
                $('#to_id').val($(triggerElement).data("user_id"));

            })
            if (location.hash) {
                $('a[href="' + location.hash + '"]').tab('show');
                // code to also show parent tabs
            }
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
