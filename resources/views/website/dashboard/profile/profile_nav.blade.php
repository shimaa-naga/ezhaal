

<div class="col-xl-3 col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{_i('My Dashboard')}}</h3>
        </div>
        @include('website.dashboard.profile_img')

        <aside class="app-sidebar doc-sidebar my-dash">
            <div class="app-sidebar__user clearfix">
                <ul class="side-menu">

                    <li class="slide">
                        <a class="side-menu__item {{ request()->is('account/profile') ? 'active' : '' }}" data-toggle="slide" href="{{route('website.profile.index')}}"><i class="side-menu__icon si si-user"></i><span class="side-menu__label">{{_i('Edit Profile')}}</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->is('account/personal_info') ? 'active' : '' }}" data-toggle="slide" href="{{ route('website.profile.personal_info') }}"><i class="side-menu__icon si si-settings"></i><span class="side-menu__label"> {{ _i('Edit account') }}</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->is('dash/messages') ? 'active' : '' }}" data-toggle="slide" href="{{ route('website.message.index') }}"><i class="side-menu__icon fa fa-inbox"></i>
                            {{--                            <span class="side-menu__label"> {{ _i('Inbox') }} <b>({{ \App\Help\Utility::messageCount() }})</b></span>--}}
                            <span class="side-menu__label"> {{ _i('Inbox') }}
                                @php
                                    $count =\App\Help\Utility::messageUnReadCount();
                                @endphp
                                @if ($count > 0)
                                    <span class="badge bg-warning">
                                         {{$count ." ". _i('New Messages') }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->is('account/skills') ? 'active' : '' }}" data-toggle="slide" href="{{ route('website.profile.skills') }}"><i class="side-menu__icon fa fa-tasks mr-1"></i><span class="side-menu__label"> {{ _i('Skills') }}</span></a>
                    </li>

                </ul>
            </div>
        </aside>
    </div>


</div>




