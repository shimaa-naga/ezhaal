<div class="card">

    <div class="card-body p-6">
        <div class="panel panel-primary">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">


                        <li class="active">
                            <a class="active" data-toggle="tab" href="#home1">{{ _i('Details') }}</a>

                        </li>
                        <li>
                            <a data-toggle="tab" href="#home">{{ _i('Bids') }}</a>

                        </li>
                        <li class="">

                            <a data-toggle="tab" href="#about-2">{{ _i('Messages') }}</a>
                        </li>
                        <li class="">

                            <a data-toggle="tab" href="#contact-2">{{ _i('Status') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">

                    <div id="home1" class="tab-pane active">
                        @include("master.projects.projects.show.project")
                    </div>
                    <div id="home" class="tab-pane ">
                        @if ($bid != null)
                            @include("master.projects.projects.show.bid")
                        @endif
                    </div>
                    <div id="about-2" class="tab-pane ">

                        <p>&nbsp;
                        </p>
                        @if ($history != null)
                            @forelse ($history as $message)
                                @include("master.projects.requests.partial.message",["message"=>$message])
                            @empty
                                {{ _i('No messages.') }}
                            @endforelse
                        @endif

                    </div>
                    <div id="contact-2" class="tab-pane ">
                        <p>
                        </p>
                        @if ($bid != null)
                            @include("website.dashboard.project_bids.show.timeline")
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


