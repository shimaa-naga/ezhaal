<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
    </div>
    <!--logo start-->
    <a href="/master/home" class="logo">Ezz<span>hal</span></a>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            {{-- <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-tasks"></i>
                    <span class="badge bg-success">6</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar">
                    <div class="notify-arrow notify-arrow-green"></div>
                    <li>
                        <p class="green">You have 6 pending tasks</p>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info">
                                <div class="desc">Dashboard v1.3</div>
                                <div class="percent">40%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info">
                                <div class="desc">Database Update</div>
                                <div class="percent">60%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info">
                                <div class="desc">Iphone Development</div>
                                <div class="percent">87%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 87%">
                                    <span class="sr-only">87% Complete</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info">
                                <div class="desc">Mobile App</div>
                                <div class="percent">33%</div>
                            </div>
                            <div class="progress progress-striped">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                                    <span class="sr-only">33% Complete (danger)</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info">
                                <div class="desc">Dashboard v1.3</div>
                                <div class="percent">45%</div>
                            </div>
                            <div class="progress progress-striped active">
                                <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 45%">
                                    <span class="sr-only">45% Complete</span>
                                </div>
                            </div>

                        </a>
                    </li>
                    <li class="external">
                        <a href="#">See All Tasks</a>
                    </li>
                </ul>
            </li> --}}
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown">
                @php
                    $complaints = \App\Help\Complaints::getOpenedTickets();
                @endphp
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-tasks"></i>
                    <span class="badge bg-important">{{ count($complaints) }}</span>
                </a>

                <ul class="dropdown-menu extended inbox">
                    <div class="notify-arrow notify-arrow-red"></div>
                    <li>
                        <p class="red">{{ _i('You have') }} {{ count($complaints) }} {{ _i('tickets') }}</p>
                    </li>
                    @foreach ($complaints as $item)
                        @php
                            $by = $item->Details->whereNull('reply_id')->first()->By;
                        @endphp
                        <li>
                            <a href="{{ url('master/complaint/' . $item->id) }}">
                                <span class="photo"><img alt="avatar"
                                        src="{{ asset('master/img/avatar-mini.jpg') }}"></span>
                                <span class="subject">
                                    <span class="from">{{ $by->name }}</span>
                                    <span class="time">
                                        {{ Carbon\Carbon::parse($item->created_at)->diffforhumans() }}</span>
                                </span>
                                <span class="message">
                                    {{ $item->Details->first()->title }}
                                </span>
                            </a>
                        </li>
                    @endforeach


                    <li>
                        <a href="{{ url('master/complaints') }}">{{ _i('See all') }}</a>
                    </li>
                </ul>
            </li>
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            @php
                $notifications = \App\Help\Notification::getMasterNotifications();
                if ($notifications == null) {
                    $notifications=[];
                }
            @endphp
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                    <i class="fa fa-bell-o"></i>
                    <span class="badge bg-warning">{{ count($notifications) }}</span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <div class="notify-arrow notify-arrow-yellow"></div>
                    <li>
                        <p class="yellow">{{ _i('You have') }} {{ count($notifications) }}
                            {{ _i('new notifications') }}
                        </p>
                    </li>
                    @foreach ($notifications as $notify)
                        <li>
                            <a href="#">
                                <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                {!! App\Help\Notification::Get($notify, '') !!}
                                <span class="small italic">
                                    {{ Carbon\Carbon::parse($notify->created_at)->diffforhumans() }}</span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ url('master/notifications') }}">{{ _i('See all notifications') }}</a>
                    </li>

                </ul>
            </li>
            <!-- notification dropdown end -->
        </ul>
    </div>
    <div class="top-nav ">
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder="Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    @php
                        $user = auth()
                            ->guard('master')
                            ->user();
                    @endphp
                    @if ($user->image != null && file_exists(public_path($user->image)))
                        <img alt="" src="{{ asset($user->image) }}" style="width: 29px; height: 29px;">
                    @else
                        <img alt="" src="{{ asset('master/img/avatar1_small.jpg') }}">
                    @endif
                    <span class="username">{{ $user->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="{{ route('master.profile.get') }}"><i
                                class=" fa fa-suitcase"></i>{{ _i('Profile') }}</a></li>
                    <li><a href="{{ route('master.settings.index') }}"><i class="fa fa-cog"></i>
                            {{ _i('Settings') }}</a></li>
                    <li><a href="{{ url('master/notifications') }}"><i class="fa fa-bell-o"></i>
                            {{ _i('Notification') }}</a></li>
                    <li><a href="{{ route('MasterLogout') }}"><i class="fa fa-key"></i> {{ _i('Log Out') }}</a>
                    </li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
    </div>
</header>
