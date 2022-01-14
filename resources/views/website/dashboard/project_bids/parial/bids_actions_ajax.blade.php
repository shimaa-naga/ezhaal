{{-- @forelse($bids as $item) --}}
    <div class="col-lg-12">

        @include("website.dashboard.project_bids.parial.bids_ajax",["buttons" => 1])

   </div>
{{-- @empty

@endforelse --}}
<p></p>
<div class="col-md-8 offset-md-4">
    {{ $bids->appends(Request::except('page'))->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Message') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('dash/message/store') }}" method="POST" id='form_add' data-parsley-validate="">
                @csrf {{ method_field('POST') }}
                <input type="hidden" name="project_id" value="{{ $id }}">
                <input type="hidden" name="subject" value="{{ $project->title }}">

                <input type="hidden" name="to_id" id="to_id" value="">

                <div class="modal-body">
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <textarea name="msg" id="msg" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="md-close" class="btn btn-secondary"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ _i('Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(function() {
            $('#exampleModal').on('shown.bs.modal', function(event) {
                var triggerElement = $(event.relatedTarget);
                $('#to_id').val($(triggerElement).data("user_id"));

            })
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('action');

                $.ajax({

                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == 'SUCCESS') {
                            $('#md-close').click();
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Sent Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();

                            $('#msg').val("");
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
        });

    </script>
@endpush
