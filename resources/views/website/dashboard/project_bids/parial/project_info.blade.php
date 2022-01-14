<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $project->title }}</h3>
    </div>

    <div class="card-body">


        @php
        $items =[];
            if ($category != null) {
                $items = App\Models\Projects\ProjcategoryAttributes::where('category_id', $category->id)
                    ->where('module', $project->type)
                    ->orderBy('sort')
                    ->get();
            }
        @endphp
        {{_i("Price")}} :
          {{$project->PriceTypeTitle}} {{$project->price}}
          <p>
              {{_i("Expiry")}} :
          {{$project->expiry}}
          </p>
        @if (count($items) > 0)
            <div class="table-responsive">


                <table class="table row table-borderless w-100 m-0 text-nowrap ">
                    <tbody class="col-lg-12 col-xl-6 p-0">


                        @include('website.dashboard.project.partial.attributes_shw',["items"=> $items,"project"
                        =>$project])

                    </tbody>
                </table>
            </div>

        @endif
        {!! nl2br($project->description) !!}

        <?php $selected_list = $project
            ->Skills()
            ->get()
            ->pluck('id')
            ->toArray(); ?>
        @if (count($selected_list) > 0)
            <label for="">{{ _i('Skills') }}</label>
            @foreach (App\Help\Skills::GetAll() as $item)
                <?php $selected = in_array($item->skill_id, $selected_list); ?>
                @if ($selected)
                    <span class="badge badge-pill badge-secondary">{{ $item->title }}</span>

                @endif

            @endforeach

        @endif
        @if (count($project->Attachments()->get()) > 0)

            @include("website.dashboard.project.partial.attach",["project" => $project,"show" => true])

        @endif
    </div>
</div>
