@php
$attr = $project
    ->category()
    ->first()
    ->attributes()
    ->where('show_public', 1)
    ->whereNotIn('type', ['image', 'doc', 'url'])
    ->where("projcategory_attributes.module",$project->type)
    ->get();

@endphp

@foreach ($attr as $key => $value)
    @php
        $find = $project->SelectedValue()->find($value->id);
        $entered = $find != null ? $find->pivot->value : '';
    @endphp


    <span class="badge badge-warning fs-12">{{ $value->trans(App::getLocale())->title }} : {{ $entered }}</span>


@endforeach
