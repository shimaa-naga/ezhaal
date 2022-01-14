
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ _i("Bids") }}</h3>
    </div>

    <div class="card-body">
        <div class="" id="div_content">
            @include("website.dashboard.project_bids.parial.bids_ajax")
        </div>
    </div>
</div>
@push("js")
    <script type="text/javascript">
     $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });
        var page = 0;
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                page = $(this).attr('href').split('page=')[1];

                getData(page);
            });

        });

        function getData(page) {

            $.ajax({
                url: '?page=' + page,
                type: "get",
                method: "get",




            }).done(function(response) {

                $("#div_content").empty().html(response);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }
    </script>
@endpush
