@if ($items != null)
    @php
        $list =
            $project != null
                ? $project
                    ->Attributes2()
                    ->where('module', $project->type)
                    ->pluck('attribute_id')
                    ->toArray()
                : [];
        $values = [];

        $list = [];
        if ($project != null) {
            $arr = $project
                ->Attributes2()
                ->where('module', $project->type)
                ->pluck('attribute_id')
                ->toArray();
            $list = array_combine_(array_column($arr, 'id'), array_column($arr, 'pivot'));
        }
        $titles = App\Models\Projects\ProjCategoryAttributes2Data::whereIn('item_id', array_column($items->toArray(), 'id'))
            ->get()
            ->toArray();
        $trans = new \App\Bll\Translate($items->toArray(), $titles, \App\Help\Utility::getLang());
        $filters = $trans->getData('item_id', ['title', 'options', 'placeholder']);

    @endphp
    @foreach ($filters as $item)
        @include("website.dashboard.project.partial.controls")

    @endforeach
@endif
