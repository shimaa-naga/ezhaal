<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a href="{{ route('MasterHome') }}" class="@if (request()->is('master/home')) active @endif">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ _i('Dashboard') }}</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/settings') ||
                    request()->is('master/settings/*') || request()->is('master/commissions') ||
                    request()->is('master/discounts')) active @endif">
                    <i class="fa fa-cogs"></i>
                    <span>{{ _i('Settings') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('master.settings.index') }}">{{ _i('Site Settings') }}</a></li>
                    <li><a href="{{ url('master/settings/currency') }}">{{ _i('Currencies') }}</a></li>
                    <li><a href="{{ url('master/settings/tags') }}">{{ _i('Meta Tags') }}</a></li>
                    <li><a href="{{ route('master.footer.index') }}">{{ _i('Footers') }}</a></li>
                    <li><a href="{{ route('master.sliders.index') }}">{{ _i('Sliders') }}</a></li>
                    <li><a href="{{ route('master.country.index') }}">{{ _i('Countries') }}</a></li>
                    <li><a href="{{ route('master.city.index') }}">{{ _i('Cities') }}</a></li>
                    <li><a href="{{ route('master.commission.index') }}">{{ _i('Commissions') }}</a></li>
                    <li><a href="{{ route('discounts.index') }}">{{ _i('Discounts') }}</a></li>
                    <li><a href="{{ route('master.work_method.index') }}">{{ _i('Work Methods') }}</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/financial/setting')) active @endif" >
                    <i class="fa fa-money"></i>
                    <span>{{ _i('financial') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('master.financial.setting') }}">{{ _i('Settings') }}</a></li>

                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/permissions') ||
                    request()->is('master/roles')) active @endif">
                    <i class="fa fa-key"></i>
                    <span>{{ _i('Security') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('master.permissions') }}">{{ _i('Permissions') }}</a></li>
                    <li><a href="{{ route('master.roles') }}">{{ _i('Roles') }}</a></li>
                    {{-- <li class="sub-menu"> --}}
                    {{-- <a  href="javascript:;">{{_i('Roles')}}</a> --}}
                    {{-- <ul class="sub"> --}}
                    {{-- <li><a  href="javascript:;">{{_i('Add')}}</a></li> --}}
                    {{-- <li><a  href="javascript:;">{{_i('All')}}</a></li> --}}

                    {{-- </ul> --}}
                    {{-- </li> --}}
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/admins/*') ||
                    request()->is('master/admins')) active @endif">
                    <i class="fa  fa-suitcase"></i>
                    <span>{{ _i('Moderators') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('master.admins') }}">{{ _i('All') }}</a></li>
                    <li><a href="{{ route('master.admins.create') }}">{{ _i('Add') }}</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/users') ||
                    request()->is('master/freelancers/*') || request()->is('master/users/*')) active @endif">
                    <i class="fa fa-users"></i>
                    <span>{{ _i('Registered Users') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ url('master/users')  }}">{{ _i('All') }}</a></li>
                    <li><a href="{{  url('master/users?buyers=1')  }}">{{ _i('Buyers') }}</a></li>
                    <li><a href="{{  url('master/users?freelancer=1')  }}">{{ _i('Freelancers') }}</a></li>
                    <li><a href="{{ url('master/freelancers/trusted') }}">{{ _i('Trusted Requests') }}</a></li>

                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/company') ||
                    request()->is('master/company/*')) active @endif">
                    <i class="fa fa-building-o"></i>
                    <span>{{ _i('Companies') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ url('master/company') }}">{{ _i('All') }}</a></li>
                    <li><a href="{{ url('master/company?provider=1') }}">{{ _i('Providers') }}</a></li>
                    <li><a href="{{ url('master/company?buyers=1') }}">{{ _i('Buyers') }}</a></li>


                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/blog_categories') ||
                    request()->is('master/blogs') || request()->is('master/blogs/*')) active @endif">
                    <i class="fa fa-edit"></i>
                    <span>{{ _i('Content Management') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('master.blog_category.index') }}">{{ _i('Blog Category') }}</a></li>
                    <li><a href="{{url('master/blogs')}}">{{ _i('Blogs') }}</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/complaint/*') ||
                    request()->is('master/complaints')) active @endif">
                    <i class="fa fa-tasks"></i>
                    <span>{{ _i('Complaints Management') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{url('master/complaint/types') }}">{{ _i('Types') }}</a></li>
                    <li><a href="{{url('master/complaint/status') }}">{{ _i('Statuses') }}</a></li>
                    <li><a href="{{url('master/complaints') }}">{{ _i('Complaints') }}</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/project/*') ||
                    request()->is('master/projects') || request()->is('master/requests')) active @endif" >
                    <i class="fa fa-asterisk"></i>
                    <span>{{ _i('Projects Management') }}</span>
                </a>
                <ul class="sub">
                    {{-- <li><a  href="{{route('master.proj_status.index')}}">{{_i('Statuses')}}</a></li> --}}
                    <li><a href="{{ route('master.proj_category.index') }}">{{ _i('Categories') }}</a></li>
                    <li><a href="{{ route('master.projects.index') }}">{{ _i('Projects') }}</a></li>
                    <li><a href="{{ url('master/requests') }}">{{ _i('Requests') }}</a></li>

                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="@if (request()->is('master/transactions/*') ||
                    request()->is('master/transactions')) active @endif" >
                    <i class="fa fa-asterisk"></i>
                    <span>{{ _i('Transactions') }}</span>
                </a>
                <ul class="sub">
                    {{-- <li><a  href="{{route('master.proj_status.index')}}">{{_i('Statuses')}}</a></li> --}}
                    <li><a href="{{ route('transactions.index') }}">{{ _i('All') }}</a></li>

                </ul>
            </li>

            {{-- <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-sitemap"></i>
                    <span>{{ _i('Bids Management') }}</span>
                </a>
                <ul class="sub">
                    <li><a href="{{ route('master.bid_status.index') }}">{{ _i('Statuses') }}</a></li>
                </ul>
            </li> --}}

            <li>
                <a href="{{ route('master.skills.index') }}">
                    <i class="fa fa-code"></i>
                    <span>{{ _i('User Skills') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.contact.index') }}">
                    <i class="fa fa-comments"></i>
                    <span>{{ _i('Contacts') }}</span>
                </a>
            </li>

            <!--multi level menu start-->
            <!--
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-sitemap"></i>
                    <span>Multi level Menu</span>
                </a>
                <ul class="sub">
                    <li><a  href="javascript:;">Menu Item 1</a></li>
                    <li class="sub-menu">
                        <a  href="boxed_page.html">Menu Item 2</a>
                        <ul class="sub">
                            <li><a  href="javascript:;">Menu Item 2.1</a></li>
                            <li class="sub-menu">
                                <a  href="javascript:;">Menu Item 3</a>
                                <ul class="sub">
                                    <li><a  href="javascript:;">Menu Item 3.1</a></li>
                                    <li><a  href="javascript:;">Menu Item 3.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
-->

            <!--multi level menu end-->

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
