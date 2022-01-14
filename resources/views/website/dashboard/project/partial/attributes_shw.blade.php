<?php
if (!function_exists('array_combine_')) {
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
$trans = new \App\Bll\Translate($items->toArray(), $titles, \App\Help\Utility::getLang());
$items = $trans->getData('item_id', ['title', 'options', 'placeholder']);
@endphp
@if ($items != null)

    @foreach ($items as $item)
        @php
            $value = '';
            $values = [];
            if (array_key_exists($item->id, $list)) {
                if ($item->type == 'multi-select' || $item->type == 'checkbox' || $item->type == 'range') {
                    $value = $list[$item->id];

                    if (!array_key_exists('value', $value)) {
                        $values = array_column($list[$item->id], 'value');
                    } else {
                        # code...

                        $values = [$list[$item->id]['value']];
                    }
                } else {
                    $value = $list[$item->id]['value'];
                }
            }
            $is_even = $loop->iteration % 2 > 0 ? 1 : 0;
            // var_dump($is_even);
        @endphp
        {{-- @if ($is_even === 1) --}}
        <tr>
            {{-- @endif --}}
            <td>
                {{-- {{ $loop->iteration }}-
            {{ $is_even }} --}}
                <span class="font-weight-bold"> {{ $item->title }}</span>

            </td>
            <td>


                @if ($item->type == 'checkbox' || $item->type == 'multi-select')
                    @foreach ($values as $child)
                        <span class="badge badge-pill badge-primary">{{ $child }}</span>
                    @endforeach
                @elseif ($item->type == 'range')
                    {{ implode(' / ', $values) }}


                @elseif ($item->type == 'image' && $value!="")
                    <img src="{{ asset($value) }}" alt="" />
                @elseif($item->type=="doc" && $value !== '')

                    <a href="{{ asset($value) }}">{{ File::basename(public_path($value)) }}</a>

                @else
                    {{ $value }}
                @endif

            </td>
            {{-- @if ($is_even === 0) --}}
        </tr>
        {{-- @endif --}}
    @endforeach
    </tr>
@endif
