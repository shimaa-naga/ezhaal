@extends('website.dashboard.index_inner', ['nav'=>true ,
'title' => _i('Message Details'),'header_title' => _i('Message Details')])

@section('content')

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Message Details')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Message Details')}}</li>
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
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('Message Details')}}</h3>
                        </div>

                        <div class="card-body">
                            <div class="btn-toolbar float-right" role="toolbar">
                                <div class="btn-group mr-1">
                                    <a type="button" href="{{ route('website.message.index') }}" title="{{ _i('Show Inbox') }}"
                                       class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-inbox"></i></a>
                                    <a type="button" href="#anchorreply" title="{{ _i('Reply') }}"
                                       class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-reply"></i></a>
                                    {{-- <a type="button" href="{{ route('website.message.index') }}" title="{{ _i('Refresh Page') }}"
                                        class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-refresh"></i></a> --}}
                                    {{-- <a type="button" href="{{ route('website.message.destroy', $message->id) }}" title="{{ _i('Delete message') }}"
                                        class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-trash-o"></i></a> --}}
                                </div>

                            </div>

                            @foreach ($history as $message)
                                @include("website.dashboard.messages.partial.show",["message"=>$message])
                            @endforeach ($message != null)


                            <hr>
                            <h4  > <i class="fa fa-mail-forward mr-2"></i> {{ _i('Reply') }}</h4>

                            <form id="anchorreply" method="POST" action="{{ route('website.message.reply', $message->id) }}" data-parsley-validate="">
                                @csrf

                                <div class="media mt-3">

                                    <div class="media-body">
                <textarea class="wysihtml5 form-control" rows="9" name="reply_msg" required=""
                          placeholder="{{ _i('Reply here') }}..."></textarea>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mt-3"><i class="fa fa-send mr-1"></i>
                                        {{ _i('Send') }}</button>
                                </div>
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
