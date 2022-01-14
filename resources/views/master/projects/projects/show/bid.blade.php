<div class="media">
    <a class="pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} " href="#">
        <img src="{{ $bid->freelancer()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($bid->freelancer()->image) }}"
            class="thumb media-object" width="50" height="50" alt="">
    </a>
    <div class="media-body">
        <h4> {{ $bid->Freelancer()->name }}

        </h4>
        <span class="text-info"> <i title="{{ _i('Created') }}" class="fa fa-clock-o"> </i>
            {{ Carbon\Carbon::parse($bid->created_at)->diffforhumans() }}
        </span>

        <span class="text-primary">
            {{ _i('Cost') }} :
            <i title="{{ _i('Cost') }}" class="fa fa-money">
                {{ $bid->priceAfter }}
                {{ \App\Help\Settings::getCurrency() }}</i>
        </span>
        <span class="text-danger">
            <i title="{{ _i('Duration') }}" class="fa fa-hourglass"></i>{{ _i('Duration') }} :
            {{ $bid->duration }}
            {{ _i('days') }}

        </span>
        <p>
            {!! nl2br(strip_tags($bid->description)) !!}
        </p>
        <p>
            @if (count($bid->Attachments()->get()) > 0)

                @include("website.dashboard.project.partial.attach",["project"
                => $bid,"show" => true])

            @endif
        </p>
    </div>
    <div>
        @if (isset($show))
            <a class="btn btn-primary col-md-12"
                href="{{ route('master.bid.show', ['id' => $bid->id]) }}">{{ _i('View') }}</a>
        @endif
    </div>
</div>
