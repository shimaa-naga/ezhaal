<?php

function array_combine_($keys, $values)
{
    $result = [];

    foreach ($keys as $i => $k) {
        $result[$k][] = $values[$i];
    }

    array_walk($result, function (&$v) {
        $v = count($v) == 1 ? array_pop($v) : $v;
    });

    return $result;
}
?>
@php

$list = [];
if ($project != null) {
    $arr = $project->SelectedValue->toArray();
    $list = array_combine_(array_column($arr, 'id'), array_column($arr, 'pivot'));
}
$titles = App\Models\Projects\ProjCategoryAttributesData::whereIn('item_id', array_column($items->toArray(), 'id'))
    ->get()
    ->toArray();

//    dd($items->toArray(),$titles,\App\Help\Utility::getLang() );
$trans = new \App\Bll\Translate($items->toArray(), $titles, \App\Help\Utility::getLang());
$filters = $trans->getData('item_id', ['title', 'options', 'placeholder']);
//dd($filters,$titles);
// $items = feature_options::whereIn("feature_id", ($features->pluck("id")))->get()->toArray();
// 		$data = feature_option_data::whereIn("feature_option_id", array_column($items, "id"))->get()->toArray();
// 		$trans = new Translate($items, $data, $this->lang_id);
// 		$filters = $trans->getData("feature_option_id", ["title", "name"]);

//dd(array_combine(array_column($titles, 'item_id'), $titles), $items->toArray());
//dd($list,$items);
@endphp
@if ($filters != null)

    @foreach ($filters as $item)
        @include("website.dashboard.project.partial.controls")
    @endforeach
@endif
