<div class="media">
    <a class="pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} " href="#">
        <img src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}"
            class="thumb media-object" width="50" height="50" alt="">
    </a>
    <div class="media-body">
        <h4>{{ $project->owner()->name }}

        </h4>
        <span class="text-info"> <i title="{{ _i('Created') }}" class="fa fa-clock-o"> </i>
            {{ $project->created_at }}
        </span>

        <span class="text-primary">
            {{ _i('Cost') }} :
            <i title="{{ _i('Cost') }}" class="fa fa-money">
                {{ $project->priceTypeTitle }} {{$project->price }}
                {{ \App\Help\Settings::getCurrency() }}</i>
        </span>
        <span class="text-danger">
            <i title="{{ _i('Expiry') }}" class="fa fa-hourglass"></i>{{ _i('Expiry') }} :
            {{ $project->ExpiryDate }}
            {{ _i('days') }}
        </span>

        @php
        $items = [];

        $items = App\Models\Projects\ProjcategoryAttributes::whereIn(
            'category_id',
            $project
                ->Category()
                ->get()
                ->pluck('id'),
        )
            ->where('module', $project->type)
            ->orderBy('sort')
            ->get();

    @endphp
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap">
            @include('website.dashboard.project.partial.attributes_shw',["items"=>
            $items,"project"=>$project])
        </table>
    </div>

    @include("website.dashboard.project.partial.basic",["type"=>$project->type])


        <p>
            {!! nl2br(strip_tags($project->description)) !!}
        </p>
        <p>
            @if (count($project->Attachments()->get()) > 0)

                @include("website.dashboard.project.partial.attach",["project"
                => $project,"show" => true])

            @endif
        </p>


    </div>
</div>
