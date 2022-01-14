<h5>{{_i("Work")}}</h5>
<ul class="input-group mb-3">
    @forelse ($bid->Work()->latest()->get() as $item)
        <?php
        $file = storage_path($item->file);
        if (file_exists($file)) { ?>
        <li id="attach-{{ $item->id }}" style="width:100%">
            <a href="{{ url('dash/bid_work/download')}}/{{$item->id}}" target="win-{{ $item->id }}">{{ basename($item->file) }}</a>
            ({{ floor(filesize(storage_path($item->file)) / 1024) }} {{ _i('KB') }})
            <br>
            <small>{{ $item->created_at }}</small>

            <p>
                {{ $item->description }}
            </p>
        </li>
        <?php }
        ?>
    @empty
        <li>
            {{ _i('No uploads exist.') }}
        </li>
    @endforelse
</ul>
