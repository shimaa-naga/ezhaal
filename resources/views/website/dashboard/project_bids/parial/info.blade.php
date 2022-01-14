<div class="col-xl-3 col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ _i('Details') }}</h3>
        </div>

        <div class="card-body text-center item-user">
            <div class="profile-pic">
                <div class="profile-pic-img">

                    <img src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}"
                        class="brround" alt="user">
                </div>
                <a href="#" class="text-dark">
                    <h4 class="mt-3 mb-0 font-weight-semibold">
                        {{ $project->owner()->name }}</h4>
                </a>

                <p class="text-muted font-size-sm">
                    {{ $project->owner()->country() != null ? $project->owner()->country()['title'] : '' }},
                    {{ $project->owner()->city() != null ? $project->owner()->city()['title'] : '' }}
                </p>
            </div>
        </div>

        <aside class="app-sidebar doc-sidebar my-dash">
            <div class="">
                <ul class="side-menu">
                    <li class="slide side-menu__item">
                        <i title="{{ _i('Budget') }}" class="side-menu__icon  fa fa-money"> </i>
                        {{ $project->PriceTypeTitle }}
                        {{-- {{ $project->budget }} --}}
                        {{ $project->price }}

                        {{-- {{ \App\Help\Settings::getCurrency() }} --}}
                    </li>
                    <li class="slide side-menu__item "><i title="{{ _i('Created') }}"
                            class="side-menu__icon fa fa-clock-o"> </i>
                        {{ Carbon\Carbon::parse($project->created_at)->diffforhumans() }}</li>
                    @if (!empty($project->duration))
                        <li class="slide side-menu__item"><i title="{{ _i('Duration') }}"
                                class="side-menu__icon fa fa-hourglass "></i> {{ $project->duration }}</li>
                    @endif
                    @php
                        $status = $project->Status()->first();
                    @endphp
                    <li class="slide side-menu__item"><strong>{{ _i('Status') }} : <i
                                class="  badge badge-{{ $project->Status()->first() != null ? $status->code : '' }}">{{ $status != null ? $status->title : '' }}</i>
                        </strong>
                    </li>
                    <li class="slide side-menu__item"><strong>{{ _i('Bids') }}</strong> :
                        {{ isset($bids) ? count($bids) : $project->bids->count() }}</li>

                </ul>
            </div>
        </aside>
    </div>


</div>
