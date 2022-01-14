<ul class="input-group mb-3">
    @foreach ($project->Attachments()->get() as $item)
        <?php
        $file = public_path($item->file);
        if (file_exists($file)) { ?>
        <li id="attach-{{ $item->id }}">
            <a href="{{ asset($item->file) }}" target="win-{{ $item->id }}">{{ basename($item->file) }}</a>
            ({{floor( filesize(public_path($item->file) )/1024)}} {{_i("KB")}})
            @if (!isset($show ))
                <a href="javascript:remove({{ $item->id }})"><i class="fa fa-remove text-danger"></i></a>
            @endif
        </li>
        <?php }
        ?>
    @endforeach
</ul>
@if (!isset($show))
@push('js')
    <script>
        function remove(id) {

            $.ajax({
                url: "attach/" + id,
                method: "delete",
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data === true) {
                        $("#attach-" + id).remove();
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: "{{ _i('No response from server') }}",
                    timeout: 2000,
                    killer: true
                }).show();
            });;
        }

    </script>
@endpush
@endif
