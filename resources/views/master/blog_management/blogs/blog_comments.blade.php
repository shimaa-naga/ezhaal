
@extends('master.layout.index' ,['title' => _i('Create Admin')])

@section('content')
    <!--breadcrumbs start -->
    <ul class="breadcrumb">
        <li><a href="{{route('MasterHome')}}"><i class="fa fa-home"></i> {{_i('Home')}}</a></li>
        <li class="active">{{_i('Blog Comments')}}</li>
    </ul>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">

        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <h5 class="panel-title">{{_i('Blog title')}}:<span class="text-muted">
                            {{ $blog_data ? $blog_data->title :_i('Blog not translation yet') }} </span> </h5>
                </header>
                <div class="panel-heading ">
                    <h6 class="panel-title">
                        <i class="fa fa-comment"></i>&nbsp; {{_i('Comments No')}}. &nbsp;<span class="text-muted text-size-small">({{count($comments)}}  {{_i('Comment')}})</span>
                    </h6>
                </div>
                <div class="row"></div>

                <div class="panel-body">

                    <div class="timeline-messages">
                        <!-- Comment -->
                        @foreach($comments as $comment)
                        <div class="msg-time-chat">
                            @php
                                $user = \App\User::where('id', $comment->user_id)->first()
                            @endphp
                            <a href="#" class="message-img"><img class="avatar"
                                src="{{ $user->image != null ? asset($user->image) : asset('custom/user-default2.jpg')}}">
                            </a>
                            <div class="message-body msg-in">
                                <span class="arrow"></span>
                                <div class="text">
                                    <p class="attribution"><a href="#">{{$user->name." ".$user->last_name}}</a>
{{--                                        at 1:55pm, 13th April 2013--}}
                                        {{_i('at')}} {{date("h:i A, d M Y ", strtotime($comment->created_at))}}
                                    </p>
                                    <p>{{$comment->comment}}</p>
                                </div>
                                <div style="margin-top: 5px;">
                                    @if($comment->published == 1)
                                    <a class="comment_approve" href="#" data-url="{{route('master.blogs.comments.approve', $comment->id)}}"><button class="btn btn-success approve_status"><i class="fa fa-check"></i> {{_i('Approved')}}</button></a>
                                    @else
                                        <a class="comment_approve" href="#" data-url="{{route('master.blogs.comments.approve', $comment->id)}}"><button class="btn btn-success approve_status">{{_i('Approve')}}</button></a>
                                    @endif
                                    <a class="comment_delete" href="#" data-url="{{route('master.blogs.comments.destroy', $comment->id)}}"><button class="btn btn-danger"><i class="fa fa-trash-o"></i> {{_i('Delete')}}</button> </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- /comment -->
                    </div>
                    <div class="row"><div class="col-sm-12"></div></div>
                    <div class="form-group row">
                        <div class="col-sm-12" style="margin-top: 30px;">
                            <a class="btn btn-default col-sm-4" href="{{url('blogs')}}">{{_i('Back')}}</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    </div>
    <!-- page end-->
@endsection
@push('js')
    <script>
        $('body').on('click', '.comment_approve', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
             var status = $(this).find('.approve_status');
            $.ajax({
                url: url,
                method: "get",
                type: "get",
                success: function (response) {
                    if (response.published == 1) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Comment Published Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        status.empty();
                        status.append(`
                         <i class="fa fa-check"></i> {{_i('Approved')}}
                        `);
                    }else{
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Comment not Publish Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        status.empty();
                        status.append(`
                         {{_i('Approve')}}
                        `);
                    }
                }
            });
        });

        $('body').on('click', '.comment_delete', function (e) {
            e.preventDefault();
            var message_row = $(this).closest('.msg-time-chat');
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: "get",
                type: "get",
                success: function (response) {
                    if (response == 'SUCCESS') {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Comment Deleted Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        message_row.remove();
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
    </script>
@endpush

