@php
$file = \App\Help\Settings::GetLogo();
@endphp
<div class="header-main">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-4 col-7">
                    <div class="top-bar-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} d-flex">
                        <div class="clearfix">
                            <ul class="socials">
                                <li>
                                    <a class="social-icon text-dark"
                                        href="{{ \App\Help\Settings::get('facebook', '#') }}"><i
                                            class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a class="social-icon text-dark"
                                        href="{{ \App\Help\Settings::get('twitter', '#') }}"><i
                                            class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a class="social-icon text-dark"
                                        href="{{ \App\Help\Settings::get('linkedin', '#') }}"><i
                                            class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a class="social-icon text-dark"
                                        href="{{ \App\Help\Settings::get('instagram', '#') }}"><i
                                            class="fa fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="clearfix">
                            <ul
                                class="contact border-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }}">
                                {{-- <li class="dropdown m{{ \App\Help\Utility::getLangCode() == 'ar' ? 'l' : 'r' }}-5">
                                    <a href="#" class="text-dark" data-toggle="dropdown">
                                        @php
                                            $default_lang = \App\Help\Utility::getMasterLang();
                                        @endphp
                                        <span> {{ _i($default_lang->title) }} <i
                                                class="fa fa-caret-down text-muted"></i></span> </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        @foreach ($langs = \App\Language::where('id', '!=', $default_lang->id)->get() as $lang)
                                            <a class="dropdown-item"
                                                href="{{ route('WebsiteLang', $lang->code) }}">{{ _i($lang['title']) }}</a>
                                        @endforeach
                                    </div>
                                </li> --}}
                                <li class="dropdown">
                                    <a href="#" class="text-dark" data-toggle="dropdown">
                                        <span>
                                            {{ \App\Help\Utility::getWebsiteCurrency()->code }}
                                            <i class="fa fa-caret-down text-muted"></i>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        @foreach (\App\Help\Utility::getCurrency() as $currency)
                                            <a class="dropdown-item"
                                                href="{{ route('WebsiteCurrency', $currency->id) }}">{{ $currency['code'] }}</a>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-sm-8 col-5">
                    <div class="top-bar-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'left' : 'right' }}">
                        <ul class="custom">
                            <li class="dropdown">
                                <a href="#" class="text-dark" data-toggle="dropdown">
                                    <i
                                        class="fa fa-globe m{{ \App\Help\Utility::getLangCode() == 'ar' ? 'l' : 'r' }}-1">
                                        @php
                                            $default_lang = \App\Help\Utility::getMasterLang();
                                        @endphp
                                        <i class="fa fa-caret-down text-muted"></i>
                                        <span> {{ _i($default_lang->title) }}</span>
                                    </i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'left' : 'right' }} dropdown-menu-arrow">
                                    @foreach ($langs = \App\Language::where('id', '!=', $default_lang->id)->get() as $lang)
                                        <a class="dropdown-item"
                                            href="{{ route('WebsiteLang', $lang->code) }}">{{ _i($lang['title']) }}</a>
                                    @endforeach
                                </div>
                            </li>

                            @auth
                                {{-- $notifications = auth()->user()->unreadNotifications; --}}
                                @php
                                    $notifications = auth()->user()->unreadNotifications;
                                @endphp


                                {{-- <li>
                                    <a class="text-dark" href="{{ url('dash/project/create') }}"> <span>
                                            {{ _i('Post Project') }}</span></a>
                                </li>
                                <li>
                                    <a class="text-gray-dark" href="{{ url('dash/service/create') }}">
                                        {{ _i('Post Service') }}</a>
                                </li> --}}
                                <li class="dropdown">
                                    <a href="#" class="text-primary" data-toggle="dropdown"><i
                                            class="fa fa-home mr-1"></i><span> {{ _i('My Dashboard') }}</span></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="{{ route('website.profile.index') }}" class="dropdown-item">
                                            <i class="dropdown-icon si si-user"></i> {{ _i('My Profile') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('website.message.index') }}">
                                            <i class="dropdown-icon si si-envelope"></i> {{ _i('Inbox') }}
                                            @if (\App\Help\Utility::messageUnReadCount() > 0)
                                                <span class="badge bg-warning">
                                                    {{ \App\Help\Utility::messageUnReadCount() . ' ' . _i('New Messages') }}
                                                </span>
                                            @endif
                                        </a>

                                        <a class="dropdown-item" href="{{ url('notifications') }}">
                                            <i class="dropdown-icon si si-bell"></i> {{ _i('Notifications') }}
                                            @if (count($notifications) > 0)
                                                <span class="badge bg-indigo ">
                                                    {{ count($notifications) }}
                                                </span>
                                            @endif
                                        </a>
                                        <a href="{{ route('website.profile.personal_info') }}" class="dropdown-item">
                                            <i class="dropdown-icon  si si-settings"></i> {{ _i('Account Settings') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ url('dash/project') }}">
                                            <i class="dropdown-icon fa fa-file-text-o"></i> {{ _i('My Deals') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ url('dash/bids/my') }}">
                                            <i class="dropdown-icon fa fa-list"></i> {{ _i('My Bids') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ url('dash/transactions') }}">
                                            <i class="dropdown-icon fa fa-dollar"></i> {{ _i('Transactions') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('website.complaints.index') }}">
                                            <i class="dropdown-icon fa fa-ticket"></i> {{ _i('Tickets') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('WebsiteLogout') }}">
                                            <i class="dropdown-icon si si-power"></i> {{ _i('Sign Out') }}
                                        </a>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <a href="{{ url('register') }}" class="text-dark"><i class="fa fa-user mr-1"></i>
                                        <span>{{ _i('Sign up') }}</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('WebsiteLogin') }}" class="text-dark"><i
                                            class="fa fa-sign-in mr-1"></i> <span>{{ _i('Sign In') }}</span></a>
                                </li>
                            @endauth

                            {{-- <li class="dropdown">
                                <a href="#" class="text-dark" data-toggle="dropdown">
                                    <i class="fa fa-globe mr-1"></i><span> My Dashboard</span></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a href="mydash.html" class="dropdown-item">
                                        <i class="dropdown-icon si si-user"></i> My Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon si si-envelope"></i> Inbox
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon si si-bell"></i> Notifications
                                    </a>
                                    <a href="mydash.html" class="dropdown-item">
                                        <i class="dropdown-icon  si si-settings"></i> Account Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon si si-power"></i> Log out
                                    </a>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Header -->
    <div class="sticky">
        <div class="horizontal-header clearfix ">
            <div class="container">



                <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
                <span class="smllogo">
                    @if ($file != null && $file != '')
                    <img src="{{asset($file) }} " width="120"  alt="" />
                    @else
                    <h2 class="text-muted"><b><a href="{{ url('/') }}">Ez<span
                        class="text-primary">haal</span></a></b></h2>
                    @endif
                </span>
                <a href="tel:245-6325-3256" class="callusbtn"><i class="fa fa-phone" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <!-- Mobile Header -->

    <div>
        <div class="horizontal-main clearfix">
            <div class="horizontal-mainwrapper container clearfix">
                <div class="desktoplogo">

                    @if ($file != null && $file != '')
                        <a href="{{ url('/') }}"><img src="{{ asset($file) }}" alt="" class="img-fluid"></a>
                    @else
                        <h2 class="text-muted"><b><a href="{{ url('/') }}">Ez<span
                                        class="text-primary">haal</span></a></b></h2>
                    @endif
                </div>
                <!--Nav-->
                <nav class="horizontalMenu clearfix d-md-flex">
                    <ul class="horizontalMenu-list">
                        <li aria-haspopup="true">
                            <a href="{{ route('WebsiteHome') }}"
                                class="{{ request()->is('/') ? 'active' : '' }}">{{ _i('Home') }} </a>
                        </li>

                        <li aria-haspopup="true">
                            <a class="nav-link scrollto {{ request()->is('projects') || request()->is('project/*') ? 'active' : '' }}"
                                href="{{ url('projects') }}">{{ _i('Deals') }}</a>
                        </li>
                        <li>
                        <li aria-haspopup="true">
                            <a class="nav-link scrollto {{ request()->is('blog/*') || request()->is('blogs/*') ? 'active' : '' }}"
                                href="{{ url('blogs/categories') }}">{{ _i('Blogs') }}</a>
                        </li>
                        <li>


                        <li aria-haspopup="true"><a class="nav-link scrollto"
                                href="{{ url('/') }}#contact">{{ _i('Contact') }}</a></li>

                        <li aria-haspopup="true"><a class="btn btn-info"
                                href="{{ url('service/create') }}">{{ _i('Sell') }}</a></li>

                        <li aria-haspopup="true"><a class="btn btn-secondary"
                                href="{{ url('projects/create') }}">{{ _i('Buy') }}</a></li>

                    </ul>
                    {{-- <ul class="mb-0">
                        <li aria-haspopup="true" class="mt-5 d-none d-lg-block ">
                            <span><a class="btn btn-secondary" href="{{ url('projects/create') }}">{{ _i('Post Project') }}</a></span>

                        </li>

                    </ul> --}}
                </nav>
                <!--Nav-->
            </div>
        </div>
    </div>
</div>
