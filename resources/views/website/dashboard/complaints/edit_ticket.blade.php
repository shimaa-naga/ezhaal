@extends('website.dashboard.index_inner', ['title' => _i('Ticket details')])

@section('content')

    @push('css')
        <link href="{{ asset('custom/timeline-vert.css') }}" rel="stylesheet">
    @endpush

    <!--timeline end-->

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Ticket details')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Ticket details')}}</li>
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
                            <h3 class="card-title">{{ $ticket->title }}</h3>
                        </div>

                        <div class="card-body">

                            <div class="member align-items-start">

                                <p>{{ _i('send time') }} : <i class="fa fa-clock-o"> {{ _i('at') }}
                                        {{ date('d M Y, h:i A ', strtotime($ticket->created)) }}</i>
                                    |
                                    {{ _i('Status') }} :

                                    {{ \App\Models\Complaints\Complaints::where('id', $ticket->complaint_id)->first()->statusDataWithLang()['title'] }}
                                    |
                                    {{ 'Type' }}
                                    :
                                    {{ $complaint_type->title }}
                                </p>
                                <hr>
                                <div class=" row">
                                    <div class="col-md-12">
                                        {{ $ticket->description }}
                                    </div>

                                </div>
                                @if (count($ticket_attachments) > 0)
                                    <div class="form-group  row">

                                        <div class="col-md-2">
                                            {{ count($ticket_attachments) }} {{ _i('attachments') }}

                                        </div>
                                        @foreach ($ticket_attachments as $key => $attachment)
                                            <div class="col-lg-3 ">
                                                <a href="{{ asset($attachment->file) ?? '' }}"
                                                   download="">{{ _i('file') }}
                                                    {{ $key + 1 }} <i class="fa fa-download"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @include("website.dashboard.complaints.timeline")

                                <h6><strong>{{ _i('New reply') }} :</strong> </h6>

                                <form id="form_comment" method="POST"
                                      action="{{ route('website.complaints.updateTicket', $ticket->complaint_id) }}"
                                      data-parsley-validate="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                                <textarea class="form-control" name="description" cols="45" rows="5"
                                                          placeholder="{{ _i('Please write the details of the message') }}"
                                                          required=""></textarea>
                                        </div>
                                    </div>
                                    <p>
                                        <strong>{{ _i('Attach files') }}</strong>
                                        <a class="btn btn-success  text-center btn-sm" id="add_file">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </p>
                                    <div class="row" id="files_box"></div>
                                    <br>
                                    <button type="submit" class="btn btn-primary col-lg-3">{{ _i('Send') }} <i
                                            class="fa fa-send"></i></button>
                                    <a href="{{ route('website.complaints.deleteTicket', $ticket->complaint_id) }}">
                                        <button type="button" class="btn btn-danger col-lg-3">{{ _i('Delete') }} <i
                                                class="fa fa-trash-o"></i></button>
                                    </a>
                                </form>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->

@endsection
@push('js')
    <script>
        $('body').on('click', '#add_file', function(e) {
            $('#files_box').append(`
                            <div class="row form-group col-sm-8" >
                                <div class="input-group mb-3">
                                    <label class="input-group-text">{{ _i('Upload') }}</label>
                                    <input type="file" class="form-control" name="ticket_files[]">
                                    <a class="btn btn-sm btn-danger del_file text-center" onclick="DeleteFile(this)" >
                                         <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            </div>
                        `);
        });

        function DeleteFile(obj) {
            $(obj).closest('.row').remove();
        }

    </script>
@endpush
