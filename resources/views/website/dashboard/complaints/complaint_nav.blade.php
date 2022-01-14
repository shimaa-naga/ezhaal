<div class="col-xl-3 col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ _i('Tickets') }}</h3>
        </div>


        <aside class="app-sidebar doc-sidebar my-dash">
            <div class="app-sidebar__user clearfix">
                <ul class="side-menu">

                    <li><a class="nav-link {{ request()->is('complaints') ? 'active' : '' }}"
                            href="{{ route('website.complaints.index') }}">{{ _i('My tickets') }}</a></li>
                    <li><a class="nav-link {{ request()->is('complaints/ticket') || request()->is('complaints/open_ticket') ? 'active' : '' }}"
                            href="{{ route('website.complaints.ticket') }}">{{ _i('Open a ticket') }}</a></li>


                </ul>
            </div>
        </aside>
    </div>


</div>
