@extends('website.layout.index2col',["form"=>true])
@section('col1')
    <form method='get' id='filter-form' action="">
        @csrf
        <ul>
            <li>
                <input type="text" name="title" class="form-control"
                    value="{{ request()->input('title') != null ? request()->input('title') : '' }}"
                    placeholder="{{ _i('Project title') }}" />
            </li>
            <li>
                <h5> {{ _i('Status') }}</h5>
            </li>
            @php
                $arr = \App\Models\Projects\BidStatus::all();

            @endphp
            @foreach ($arr as $key => $item)
                <li>
                    <input type="checkbox" {{ $selecetedState != null && $selecetedState == $item->title ? "checked=''" : '' }}
                        id="li_{{ $key }}" class="form-check-input filled-in" value="{{ $item->id }}"
                        name="state[]">
                    <label class="form-check-label small text-uppercase card-link-secondary" for="li_{{ $key }}">
                        {{ $item->title }}</label>
                </li>
            @endforeach

        </ul>
    </form>
@endsection
@section('col2')
    @csrf
    <h5>
        {{ _i('My Bids') }}
    </h5>
    <div id="projects_filter">
    @include("website.dashboard.project_bids.my.all.ajax")
    </div>
@endsection
@push('js')
    <script>


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
                type: "post",
                method: "post",
                data: new FormData($('#filter-form')[0]),
                cache       : false,
                contentType : false,
                processData : false,
            }).done(function(response) {
                $('#projects_filter').empty().html(response);
                //$("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }


        $(document).on('change', '#filter-form :input', function() {
            getData(page);

        })

    </script>
@endpush
