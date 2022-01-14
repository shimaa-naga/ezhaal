
<div class="app-header1 header py-1 d-flex">
    <div class="container-fluid">
        <div class="d-flex">
            <a href="{{route('WebsiteHome')}}" class="logo header-brand">Ezz<span class="text-primary">hal</span></a>
{{--            <a class="header-brand" href="index.html">--}}
{{--                <img src="{{asset('website2/assets/images/brand/logo1.png')}}" class="header-brand-img" alt="Pinlist logo">--}}
{{--            </a>--}}
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
            <div class="header-navicon">
                <a href="#" data-toggle="search" class="nav-link d-lg-none navsearch-icon">
                    <i class="fa fa-search"></i>
                </a>
            </div>
            <!----
            <div class="header-navsearch">
                <a href="#" class=" "></a>
                <form class="form-inline mr-auto">
                    <div class="nav-search">
                        <input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" >
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            -->
            <div class="d-flex order-lg-2 @if(\App\Help\Utility::getLangCode() == 'ar') mr-auto @else ml-auto @endif">
                <div class="dropdown d-none d-md-flex" >
                    <a  class="nav-link icon full-screen-link">
                        <i class="fe fe-maximize floating"  id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="dropdown d-none d-md-flex country-selector">
                    <a href="#" class="d-flex nav-link leading-none" data-toggle="dropdown">
                        <i class=" si si-globe"></i> &nbsp;
                        <div>
                            @php
                            $default_lang = \App\Help\Utility::getMasterLang();
                            @endphp
                            <strong class="text-dark"> {{_i($default_lang->title) }} </strong>
                        </div>
                    </a>
                    <div class="language-width dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @foreach ($langs = \App\Language::where('id',"!=",$default_lang->id)->get() as $lang)
                            <a href="{{ route('master.lang', $lang->code) }}" class="dropdown-item d-flex pb-3">
                                <div>
                                    <strong>{{ _i($lang['title']) }}</strong>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <!-- notification dropdown start-->
                @php
                    $notifications = \App\Help\Notification::getMasterNotifications();
                    if ($notifications == null) {
                        $notifications=[];
                    }
                @endphp
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class=" nav-unread badge badge-danger  badge-pill">{{ count($notifications) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item text-center">
                            <p class="yellow">{{ _i('You have') }} {{ count($notifications) }}
                                {{ _i('new notifications') }}
                            </p>
                        </a>
                        <div class="dropdown-divider"></div>
                        @foreach ($notifications as $notify)
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div>
                                <strong>{!! App\Help\Notification::Get($notify, '') !!}</strong>
                                <div class="small text-muted">{{ Carbon\Carbon::parse($notify->created_at)->diffforhumans() }}</div>
                            </div>
                        </a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('master/notifications') }}" class="dropdown-item text-center">{{ _i('See all notifications') }}</a>
                    </div>
                </div>
                <!-- inbox dropdown start-->
                @php
                    $complaints = \App\Help\Complaints::getOpenedTickets();
                @endphp
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fa fa-envelope-o "></i>
                        <span class=" nav-unread badge badge-warning  badge-pill">{{ count($complaints) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item text-center">
                            <p class="red">{{ _i('You have') }} {{ count($complaints) }} {{ _i('tickets') }}</p>
                        </a>
                        <div class="dropdown-divider"></div>
                        @foreach ($complaints as $item)
                            @php
                                $by = $item->Details->whereNull('reply_id')->first()->By;
                            @endphp
                        <a href="{{ url('master/complaint/' . $item->id) }}" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('website2/assets/images/faces/male/41.jpg')}}" alt="avatar-img" class="avatar brround mr-3 align-self-center">
                            <div>
                                <strong>{{ $by->name }}</strong> {{ $item->Details->first()->title }}
                                <div class="small text-muted">{{ Carbon\Carbon::parse($item->created_at)->diffforhumans() }}</div>
                            </div>
                        </a>
                        @endforeach

                        <div class="dropdown-divider"></div>
                        <a href="{{ url('master/complaints') }}" class="dropdown-item text-center">{{ _i('See all') }}</a>
                    </div>
                </div>

                <!-----
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-grid"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow  app-selector">
                        <ul class="drop-icon-wrap">
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="si si-envelope text-dark"></i>
                                    <span class="block"> E-mail</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="si si-map text-dark"></i>
                                    <span class="block">map</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="si si-bubbles text-dark"></i>
                                    <span class="block">Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="si si-user-follow text-dark"></i>
                                    <span class="block">Followers</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="si si-picture text-dark"></i>
                                    <span class="block">Photos</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="si si-settings text-dark"></i>
                                    <span class="block">Settings</span>
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all</a>
                    </div>
                </div>
                ------->

                <div class="dropdown ">
                    @php
                        $user = auth()
                            ->guard('master')
                            ->user();
                    @endphp
                    <a href="#" class="nav-link pr-0 leading-none user-img" data-toggle="dropdown">
                        @if ($user->image != null && file_exists(public_path($user->image)))
                            <img src="{{ asset($user->image) }}" alt="profile-img" class="avatar avatar-md brround">
                        @else
                            <img src="{{asset('website2/assets/images/faces/male/25.jpg')}}" alt="profile-img" class="avatar avatar-md brround">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <a class="dropdown-item" href="{{ route('master.profile.get') }}">
                            <i class="dropdown-icon si si-user"></i> {{ _i('Profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ url('master/notifications') }}">
                            <i class="dropdown-icon si si-bell"></i> {{ _i('Notification') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('master.settings.index') }}">
                            <i class="dropdown-icon  si si-settings"></i> {{ _i('Settings') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('MasterLogout') }}">
                            <i class="dropdown-icon si si-power"></i> {{ _i('Log Out') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
