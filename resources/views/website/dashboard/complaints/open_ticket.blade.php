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
                            <h3 class="card-title">{{_i('Ticket details')}}</h3>
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
                                        {{_i('We ask that you provide us with all the details of the request or the problem you are facing so that we can solve it as soon as possible')}}.
                                    </p>

                                    <br>

                                    <form  id="form_comment" method="POST" action="{{ route('website.complaints.send_ticket') }}" data-parsley-validate="" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="complaint_type" value="{{$ticket_type}}">
                                        <div class="form-group row">
                                            <label for="subject" class="col-lg-2 col-form-label">{{_i('Subject')}} :</label>
                                            <div class="col-lg-10">
                                                <input id="subject" class="form-control" type="text" name="title" required=""  placeholder="{{_i('Please write the subject of the message')}}"
                                                       maxlength="255" data-parsley-maxlength="255">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                               <textarea class="form-control" name="description" cols="45"
                                                         rows="8" placeholder="{{ _i('Please write the details of the message') }}"
                                                         required=""></textarea>
                                            </div>
                                        </div>
                                        <p >
                                            <strong>{{_i('Attach files')}}</strong>
                                            <a  class="btn btn-success  text-center btn-sm" id="add_file">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </p>

                                        <div class="row" id="files_box">
{{--                                            <div class=" form-group" >--}}
{{--                                                <div class="input-group mb-3">--}}
{{--                                                    <label class="input-group-text">{{_i('Upload')}}</label>--}}
{{--                                                    <input type="file" class="form-control" name="ticket_files[]">--}}
{{--                                                    <a href="#" class="btn btn-sm btn-danger del_file text-center" onclick="DeleteFile(this)" >--}}
{{--                                                        <i class="fa fa-trash-o"></i>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div>

                                        <br>
                                        <button type="submit" class="btn btn-primary col-lg-3">{{_i('Send')}} <i class="fa fa-send"></i></button>
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

@push('js')
    <script>
        $('body').on('click','#add_file',function (e) {
            $('#files_box').append(`
            <div class="row form-group col-sm-8" >
                <div class="input-group mb-3">
                    <label class="input-group-text">{{_i('Upload')}}</label>
                    <input type="file" class="form-control" name="ticket_files[]">
                    <a class="btn btn-sm btn-danger del_file text-center" onclick="DeleteFile(this)" >
                         <i class="fa fa-trash-o"></i>
                    </a>
                </div>
            </div>
        `);
        });

        function DeleteFile(obj)
        {
            $(obj).closest('.row').remove();
        }
    </script>
@endpush



