<div class="col-xl-3 col-lg-12 col-md-12">
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">{{_i('Search for Bids')}}</h3>
        </div>
        <div class="card-body">
            <form method='get' id='filter-form' action="">
                @csrf
                <ul class="list-unstyled widget-spec  mb-0">
                    <li class="">
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
                        <li class="m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-5 mb-0">
                            <input type="checkbox" {{ $selecetedState != null && $selecetedState == $item->title ? "checked=''" : '' }}
                            id="li_{{ $key }}" class="form-check-input filled-in" value="{{ $item->id }}"
                                   name="state[]">
                            <label class="form-check-label small text-uppercase card-link-secondary" for="li_{{ $key }}">
                                {{ $item->title }}</label>
                        </li>
                    @endforeach

                </ul>
            </form>

        </div>
    </div>



</div>
