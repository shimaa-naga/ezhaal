@php
$type = auth('web')->user()->account_type;
$trust = new App\Help\TrustedAccount($type,auth('web')->id());

@endphp
<div class="card p-3">
    <div class="e-navlist e-navlist--active-bg">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link px-2 " href="{{ route('website.profile.index') }}"><i
                        class="fa fa-fw fa-user mr-1"></i><span>{{ _i('Profile') }}</span></a></li>
            <li class="nav-item">
                @if (!$trust->isTrusted())
                    <a class="nav-link px-2" href="{{ url('account/trusted') }}">
                @endif
                <i class="fa fa-fw fa-certificate mr-1"></i><span>
                    {{ $trust->Text() }}</span>
                @if (!$trust->isTrusted())
                    </a>
                @endif
            </li>
            <li class="nav-item"><a class="nav-link px-2 " href="{{ route('website.profile.skills') }}"><i
                        class="fa fa-fw  fa-tasks mr-1"></i><span>{{ _i('Skills') }}</a>
            </li>
        </ul>
    </div>
</div>
