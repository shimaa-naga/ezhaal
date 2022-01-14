<section class="panel">
    <header class="panel-heading">
        <h5 class="panel-title">{{ _i('Number') }} : <span class="text-muted">{{ $complaint->id }}</span>
            <p>
                {{ _i('Date') }}: <span class="text-muted">{{ $complaint['created'] }}</span></p>

                <img class="pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} " src="{{ asset($complaint_details->By->profilePhoto) }}" width="50px">
            <p class="">
                {{ $complaint_user['name'] . ' ' . $complaint_user['last_name'] }}
                <br />
                &lt;{{ $complaint_details->By->email }}&gt;
            </p>


        </h5>

    </header>
    <div class="panel-body">

        <div class="form-group">
            <label for="title">{{ $complaint_details['title'] }}</label>

        </div>
        <div class="form-group">
            {{ $complaint_details['description'] }}
        </div>
        <div class="form-group  ">
            <label>{{ _i('Attachments') }} :</label>
            @foreach ($complaint_attachments as $key => $attachment)
                <div class="form-group row text-center">
                    <div class="col-sm-12 ">
                        <a href="{{ asset($attachment->file) ?? '' }}" download=""
                            class="btn btn-success col-sm-5">{{ _i('file') }} {{ $key + 1 }} <i
                                class="fa fa-download"></i></a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
