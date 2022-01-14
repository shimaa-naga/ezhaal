@php
    $user =auth("web")->user();
    $type = auth('web')->user()->account_type;
    $trust = new App\Help\TrustedAccount($type,auth('web')->id());
@endphp
<div class="card-body text-center item-user">
    <div class="profile-pic">
        <div class="profile-pic-img">
            <span class="bg-success dots" data-toggle="tooltip" data-placement="top" title="" data-original-title="online"></span>
            <img src="@if ($user->image != null && file_exists(public_path($user->image))) {{ asset($user->image) }} @else {{ asset('uploads/users/user-default2.jpg') }} @endif" class="brround" alt="user">
        </div>
        <a href="{{route('website.profile.index')}}" class="text-dark"><h4 class="mt-3 mb-0 font-weight-semibold">{{ $user->name . ' ' . $user->last_name }}</h4></a>
        <li class="nav-item">
            @if (!$trust->isTrusted())
                <a class="nav-link px-2" href="{{ url('account/trusted') }}">
                    @endif
                    <i class="fa fa-fw fa-certificate mr-1"></i><span>{{ $trust->Text() }}</span>
                    @if (!$trust->isTrusted())
                </a>
            @endif
        </li>
        <p class="text-muted font-size-sm">
            {{ $user->country() != null ? $user->country()['title'] : '' }},
            {{ $user->city() != null ? $user->city()['title'] : '' }}
        </p>
        {{--                                <hr>--}}
        {{--                                <a class="nav-link" href="{{ route('website.profile.personal_info') }}">{{ _i('Edit account') }}--}}
        {{--                                    <i class="fa fa-external-link"></i></a>--}}
    </div>
</div>
