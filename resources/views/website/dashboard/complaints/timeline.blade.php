<div class="text-center mbot30">
    <h3 class="timeline-title">{{ _i('History') }}</h3>
    <p class="t-info">{{ _i('ticket history') }}</p>
</div>
<div class="timeline">
    @php
        $colors = ['red', 'green', 'blue', 'purple'];
        $color_index = 0;
    @endphp
    @foreach ($replies as $reply)
        @php
            if ($color_index >= count($colors)) {
                $color_index = 0;
            }
            $color = $colors[$color_index];
            $color_index++;
            $user =\App\User::find($reply->by_id);
        @endphp

        <article class="timeline-item  {{ $loop->odd ? 'alt' : '' }}">
            <div class="timeline-desk {{ $loop->odd ? 'alt' : '' }}">
                <div class="panel">
                    <div class="panel-body">
                        <span class="arrow-alt"></span>
                        <span class="timeline-icon {{ $color }}"></span>
                        <span class="timeline-date">{{ date('h:i A ', strtotime($reply->created_at)) }}</span>
                        <h1 class="{{ $color }}">{{ date('d M Y D ', strtotime($reply->created_at)) }}</h1>
                        <p><a href="#">
                                @if ($reply->by_id == auth()->id())
                                {{ _i('Yours') }} @else <img src="{{ $user->profilePhoto }}" class="pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} " width="50px"> {{ $user->name }} @endif :
                            </a> {{ $reply->description }}
                            @if ($reply->status_id != 0)
                                <span class="badge badge-success">
                                    {{ \App\Help\Complaints::getStatusTitle($reply->status_id, \App\Help\Utility::getLang()) }}
                                </span>
                            @endif
                            <p>
                            @foreach (App\Models\Complaints\ComplaintAttachments::where('complaint_id', $reply->id)->get() as $key => $attachment)

                                <a href="{{ asset($attachment->file) ?? '' }}" download="">{{ _i('file') }}
                                    {{ $key + 1 }} <i class="fa fa-download"></i></a>

                            @endforeach
                            </p>

                        </p>
                    </div>
                </div>
            </div>
        </article>
    @endforeach


</div>

<div class="clearfix">&nbsp;</div>
