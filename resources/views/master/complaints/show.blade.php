@extends('master.layout.index' ,['title' => _i('Complaint details')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Complaint details') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item "><a href="{{ url('master/complaints') }}">{{ _i('All Complaints') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Complaint details') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">

        <div class="col-lg-8">
            <section class="card">

                <div class="card-body">
                    <form role="form" method="POST" action="{{ $complaint->id }}/status" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group ">
                            <div class="row">
                            <div class="col-md-5">
                                <label for="type" class="control-label">{{ _i('Complaint Type') }} :</label>
                                <select name='type_id' id="type" class='form-control' required="">
                                    @foreach ($complaint_types as $comp_type)
                                        <option value='{{ $comp_type->type_id }}'
                                            {{ $complaint->type_id == $comp_type->type_id ? 'selected' : '' }}>
                                            {{ $comp_type->title }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-5">
                                <label for="status" class="control-label">{{ _i('Complaint Status') }} :</label>
                                <select name='status_id' id="status" class='form-control' required="">
                                    @foreach ($complaint_status as $comp_status)
                                        <option value='{{ $comp_status->status_id }}'
                                            {{ $complaint->status_id == $comp_status->status_id ? 'selected' : '' }}>
                                            {{ $comp_status->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label"></label>
                                <button class="form-control  btn btn-primary" type="submit">{{ _i('Update') }}</button>
                            </div>
                        </div>
                    </form>

                    <hr style="border-top: 5px solid #b5afaf;">
                    <div class="form-group ">
                        <label>{{ _i('Complaint replies') }} :</label>
                        @if (count($complaint_replies) > 0)
                            @foreach ($complaint_replies as $reply)
                                <div class=" msg-in form-group">
                                    <span class="arrow"></span>

                                        <div class="alert @if ($reply->by_id == $complaint_details['by_id'])  alert-secondary @else alert-warning @endif ">
                                            @php
                                                $admin = \App\User::where('id', $reply->by_id)->first();
                                            @endphp
                                            @if($admin!=null)
                                            <p class="attribution"><a
                                                    href="#">{{ $admin['name'] . ' ' . $admin['last_name'] }}
                                                   </a>
                                                {{ _i('at') }} {{ $reply->created_at }}
                                            </p>
                                            @endif
                                            <p>{{ $reply->description }}
                                                @if ($reply->status_id != 0)
                                                    <span class="label label-success">
                                                        {{ \App\Help\Complaints::getStatusTitle($reply->status_id, \App\Help\Utility::getLang()) }}
                                                    </span>
                                                @endif
                                            </p>
                                            <p>ff
                                                @foreach (App\Models\Complaints\ComplaintAttachments::where('complaint_id', $reply->id)->get() as $key => $attachment)

                                                    <a href="{{ asset($attachment->file) ?? '' }}"
                                                        download="">{{ _i('file') }}
                                                        {{ $key + 1 }} <i class="fa fa-download"></i></a>

                                                @endforeach
                                            </p>
                                        </div>
                                    {{-- @endif --}}
                                </div>
                            @endforeach
                        @else
                            <span class="text-muted">{{ _i('no replies yet') }} .</span>
                        @endif
                    </div>

                    <form role="form" method="POST" action="{{ route('master.complaints.reply') }}"
                        data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="complaintId" value="{{ $complaint->id }}">
                        <input type="hidden" name="complaintDetailsId" value="{{ $complaint_details->id }}">
                        <div class="form-group">
                            <label>{{ _i('Reply to complaint') }} : </label>
                            <textarea class="form-control" rows="5" name="reply_to_complaint"
                                placeholder="reply to user complaint..."></textarea>
                        </div>

                        <p>
                            <strong>{{ _i('Attach files') }}</strong>
                            <a class="btn btn-success  text-center btn-sm" id="add_file">
                                <i class="fa fa-plus"></i>
                            </a>
                        </p>
{{--                        <div class="form-group" id="files_box"></div>--}}
{{--                        <br>--}}
                        <div class="form-group " id="files_box">
                        </div>


                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary col-sm-4">
                                <i class="fa fa-reply"></i>
                                {{ _i('Reply') }}</button>
                            <a class="btn btn-gray col-sm-4"
                                href="{{ route('master.complaints.index') }}">{{ _i('Back') }}</a>
                        </div>

                    </form>
                </div>
            </section>
        </div>
        <div class="col-lg-4">
            @include("master.complaints.show.info")

        </div>

    </div>

    <!-- page end-->
@endsection
@push('js')
    <script>
        $('body').on('click', '#add_file', function(e) {
            $('#files_box').append(`
<div class="row">
                                                    <div class="col-md-8" >
                                                        <div class=" mb-3">

                                                            <input type="file" class="form-control" name="ticket_files[]">

                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" >
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
@push('css')
    <style>
        .msg-in .text {
            border: 1px solid #e3e6ed;
            padding: 10px;
            border-radius: 4px;
            -webkit-border-radius: 4px;
        }



    </style>
@endpush
