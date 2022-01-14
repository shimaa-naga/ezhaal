@php
    $left =\App\Help\Utility::getLangCode()=="ar" ? "left" : "right";
@endphp
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar doc-sidebar">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div>
                <img src="{{asset('website2/assets/images/faces/male/25.jpg')}}" alt="user-img" class="avatar avatar-lg brround">
                <a href="{{ route('master.profile.get') }}" class="profile-img">
                    <span class="fa fa-pencil" aria-hidden="true"></span>
                </a>
            </div>
            @php
                $user = auth()
                    ->guard('master')
                    ->user();
            @endphp
            <div class="user-info">
                <h2>{{ $user->name }}</h2>
                <span>{{_i('Administrator')}}</span>
            </div>
        </div>
    </div>

    <ul class="side-menu">
        <li>


            <a class="side-menu__item @if (request()->is('master/home')) active @endif" href="{{ route('MasterHome') }}">
                <i class="side-menu__icon fa fa-tachometer"></i><span class="side-menu__label">{{ _i('Dashboard') }}</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item @if (request()->is('master/settings') ||
                    request()->is('master/settings/*') || request()->is('master/commissions') ||
                    request()->is('master/discounts')) active @endif" data-toggle="slide" href="#"> <i class="side-menu__icon fa fa-cogs"></i>
               <span class="side-menu__label">{{ _i('Settings') }}</span><i class="angle fa fa-angle-{{$left}}"></i>
            </a>
            <ul class="slide-menu">
                <li class="@if (request()->is('master/settings')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings')) active @endif" href="{{ route('master.settings.index') }}">{{ _i('Site Settings') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/currency')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/currency')) active @endif" href="{{ url('master/settings/currency') }}">{{ _i('Currencies') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/tags')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/tags')) active @endif" href="{{ url('master/settings/tags') }}">{{ _i('Meta Tags') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/footers')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/footers')) active @endif" href="{{ route('master.footer.index') }}">{{ _i('Footers') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/sliders')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/sliders')) active @endif" href="{{ route('master.sliders.index') }}">{{ _i('Sliders') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/countries')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/countries')) active @endif" href="{{ route('master.country.index') }}">{{ _i('Countries') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/cities')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/cities')) active @endif" href="{{ route('master.city.index') }}">{{ _i('Cities') }}</a>
                </li>
                <li class="@if(request()->is('master/commissions')) active @endif">
                    <a class="slide-item @if(request()->is('master/commissions')) active @endif" href="{{ route('master.commission.index') }}">{{ _i('Commissions') }}</a>
                </li>
                <li class="@if(request()->is('master/discounts')) active @endif">
                    <a class="slide-item @if(request()->is('master/discounts')) active @endif" href="{{ route('discounts.index') }}">{{ _i('Discounts') }}</a>
                </li>
                <li class="@if(request()->is('master/settings/work_methods')) active @endif">
                    <a class="slide-item @if(request()->is('master/settings/work_methods')) active @endif" href="{{ route('master.work_method.index') }}">{{ _i('Work Methods') }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="side-menu__item @if(request()->is('master/financial/setting')) active @endif" href="{{ route('master.financial.setting')}}">
                <i class="side-menu__icon fa fa-money"></i><span class="side-menu__label">{{ _i('financial') }}</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item @if(request()->is('master/permissions') ||request()->is('master/roles')||request()->is('master/roles/users/*')) active @endif"
               data-toggle="slide" href="#"><i class="side-menu__icon fa fa-key"></i>
                <span class="side-menu__label">{{ _i('Security') }}</span><i class="angle fa fa-angle-{{$left}}"></i>
            </a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/permissions')) active @endif">
                    <a class="slide-item @if(request()->is('master/permissions')) active @endif" href="{{ route('master.permissions') }}" >{{ _i('Permissions') }}</a>
                </li>
                <li class="@if(request()->is('master/roles')||request()->is('master/roles/users/*')) active @endif">
                    <a class="slide-item @if(request()->is('master/roles')) active @endif" href="{{ route('master.roles') }}" >{{ _i('Roles') }}</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item @if(request()->is('master/admins') ||request()->is('master/admins/*')) active @endif"
               data-toggle="slide" href="#"><i class="side-menu__icon fa fa-suitcase"></i>
                <span class="side-menu__label">{{ _i('Moderators') }}</span><i class="angle fa fa-angle-{{$left}}"></i>
            </a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/admins')) active @endif">
                    <a class="slide-item @if(request()->is('master/admins')) active @endif" href="{{ route('master.admins') }}">{{ _i('All') }}</a>
                </li>
                <li class="@if(request()->is('master/admins/create')) active @endif">
                    <a class="slide-item @if(request()->is('master/admins/create')) active @endif" href="{{ route('master.admins.create') }}">{{ _i('Add') }}</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item @if(request()->is('master/users') ||request()->is('master/freelancers/*')|| request()->is('master/users/*')) active @endif"
               data-toggle="slide" href="#"><i class="side-menu__icon fa fa-users"></i>
                <span class="side-menu__label">{{ _i('Registered Users') }}</span><i class="angle fa fa-angle-{{$left}}"></i>
            </a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/users')) active @endif">
                    <a class="slide-item @if(request()->is('master/users')) active @endif" href="{{ url('master/users')}}">{{ _i('All') }}</a>
                </li>
                <li class="@if(request()->is('master/users?buyers=1')) active @endif">
                    <a class="slide-item @if(request()->is('master/users?buyers=1')) active @endif" href="{{ url('master/users?buyers=1')}}">{{ _i('Buyers') }}</a>
                </li>
                <li class="@if(request()->is('master/users?freelancer=1')) active @endif">
                    <a class="slide-item @if(request()->is('master/users?freelancer=1')) active @endif" href="{{ url('master/users?freelancer=1')}}">{{ _i('Freelancers') }}</a>
                </li>
                <li class="@if(request()->is('master/freelancers/trusted')) active @endif">
                    <a class="slide-item @if(request()->is('master/freelancers/trusted')) active @endif" href="{{ url('master/freelancers/trusted') }}">{{ _i('Trusted Requests') }}</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item @if(request()->is('master/company') ||request()->is('master/company/*')) active @endif"
               data-toggle="slide" href="#"><i class="side-menu__icon fa fa-cubes"></i>
                <span class="side-menu__label">{{ _i('Companies') }}</span><i class="angle fa fa-angle-{{$left}}"></i>
            </a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/company')) active @endif">
                    <a class="slide-item @if(request()->is('master/company')) active @endif" href="{{ url('master/company')}}">{{ _i('All') }}</a>
                </li>
                <li class="@if(request()->is('master/company?provider=1')) active @endif">
                    <a class="slide-item @if(request()->is('master/company?provider=1')) active @endif" href="{{ url('master/company?provider=1') }}">{{ _i('Providers') }}</a>
                </li>
                <li class="@if(request()->is('master/company?buyers=1')) active @endif">
                    <a class="slide-item @if(request()->is('master/company?buyers=1')) active @endif" href="{{ url('master/company?buyers=1') }}">{{ _i('Buyers') }}</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item @if(request()->is('master/blog_categories') || request()->is('master/blogs') || request()->is('master/blogs/*')) active @endif" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-edit"></i><span class="side-menu__label">{{ _i('Content Management') }}</span><i class="angle fa fa-angle-{{$left}}"></i>
            </a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/blog_categories')) active @endif">
                    <a class="slide-item @if(request()->is('master/blog_categories')) active @endif" href="{{ route('master.blog_category.index') }}">{{ _i('Blog Category') }}</a>
                </li>
                <li class="@if(request()->is('master/blogs')|| request()->is('master/blogs/*')) active @endif">
                    <a class="slide-item @if(request()->is('master/blogs')) active @endif" href="{{url('master/blogs')}}">{{ _i('Blogs') }}</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item @if (request()->is('master/complaint/*') || request()->is('master/complaints')) active @endif" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-tasks"></i><span class="side-menu__label">{{ _i('Complaints Management') }}</span><i class="angle fa fa-angle-{{$left}}"></i></a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/complaint/types')) active @endif">
                    <a  class="slide-item @if(request()->is('master/complaint/types')) active @endif" href="{{url('master/complaint/types') }}">{{ _i('Types') }} </a>
                </li>
                <li class="@if(request()->is('master/complaint/status')) active @endif">
                    <a class="slide-item @if(request()->is('master/complaint/status')) active @endif" href="{{url('master/complaint/status') }}">{{ _i('Statuses') }} </a>
                </li>
                <li class="@if(request()->is('master/complaints')) active @endif">
                    <a  class="slide-item @if(request()->is('master/complaints')) active @endif" href="{{url('master/complaints') }}">{{ _i('Complaints') }} </a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item @if (request()->is('master/project/*') || request()->is('master/projects') || request()->is('master/requests')) active @endif" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-database"></i><span class="side-menu__label"> {{ _i('Projects Management') }}</span><i class="angle fa fa-angle-{{$left}}"></i></a>
            <ul class="slide-menu">
                <li class="@if(request()->is('master/project/category')) active @endif">
                    <a class="slide-item @if(request()->is('master/project/category')) active @endif" href="{{ route('category.index') }}">{{ _i('Categories') }}</a>
                </li>
                <li class="@if(request()->is('master/projects')) active @endif">
                    <a class="slide-item @if(request()->is('master/projects')) active @endif" href="{{ route('master.projects.index') }}">{{ _i('Projects') }}</a>
                </li>
                <li class="@if(request()->is('master/requests')) active @endif">
                    <a class="slide-item @if(request()->is('master/requests')) active @endif" href="{{ url('master/requests') }}">{{ _i('Requests') }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="side-menu__item @if (request()->is('master/transactions/*') || request()->is('master/transactions')) active @endif" href="{{ route('transactions.index')}}">
                <i class="side-menu__icon fa fa-asterisk"></i><span class="side-menu__label">{{ _i('Transactions') }}</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item @if (request()->is('master/skills')) active @endif" href="{{ route('master.skills.index')}}">
                <i class="side-menu__icon fa fa-code"></i><span class="side-menu__label">{{ _i('User Skills') }}</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item @if (request()->is('master/contacts')) active @endif" href="{{ route('master.contact.index')}}">
                <i class="side-menu__icon fa fa-comments"></i><span class="side-menu__label">{{ _i('Contacts') }}</span>
            </a>
        </li>
    </ul>
    <!------
    <div class="app-sidebar-footer">
        <a href="emailservices.html">
            <span class="fa fa-envelope" aria-hidden="true"></span>
        </a>
        <a href="profile.html">
            <span class="fa fa-user" aria-hidden="true"></span>
        </a>
        <a href="editprofile.html">
            <span class="fa fa-cog" aria-hidden="true"></span>
        </a>
        <a href="login.html">
            <span class="fa fa-sign-in" aria-hidden="true"></span>
        </a>
        <a href="chat.html">
            <span class="fa fa-comment" aria-hidden="true"></span>
        </a>
    </div>
    ---->
</aside>

