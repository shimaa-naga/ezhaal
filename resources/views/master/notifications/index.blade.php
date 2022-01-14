@extends('master.layout.index',["title" => _i("Notifications")])

@section('content')
    <div class="card" id="content">
        @include("master.notifications.render.index",["notifications"=>$notifications])
    </div>

@endsection
@push('js')
    <script>
        $('body').on('submit', '.readform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var btn = this;
            $.ajax({
                url: url,
                method: "post",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === "ok") {

                        $("#content").html(response.data);
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('OK') }}",
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
            });
        });
        //delete
        $('body').on('submit', '.delform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var btn = this;
            $.ajax({
                url: url,
                method: "delete",
                type: "delete",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status=="ok") {
                        $("#content").html(response.data);
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('OK') }}",
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
            });
        });

    </script>

@endpush
