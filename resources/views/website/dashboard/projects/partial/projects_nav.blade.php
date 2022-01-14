<?php
function draw($category, $filter_category,$depth=0)
{
    $ml = "m".(\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l');
    $ml .="-";
    $ml .= (2* $depth );
    ?>
<label class="custom-control custom-checkbox mb-3 {{ $ml }}">
    <input type="checkbox" {{ $filter_category != '' && $filter_category == $category->id ? "checked=''" : '' }}
        class="custom-control-input" id="cat_{{ $category->id }}" value="{{ $category->id }}" name="category_ids[]">
    <span class="custom-control-label">
        {{ $category->DataWithLang()->title }}
        <span class="label label-secondary float-right">{{ count($category->Projects) }}</span>

    </span>
</label>
<?php
    if ($category->children()->count() != 0) {
        foreach ($category->children() as $child) {
            $depth++;
            draw($child, $filter_category,$depth);
        }
    }
}

?>

<form method='get' id='filter-form' action="">
    @csrf

    <div class="card">

        <div class="card-body">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>

            <input type="text" name="title" class="form-control"
                value="{{ request()->input('title') != null ? request()->input('title') : '' }}"
                placeholder="{{ _i('Search') }}" />
        </div>
        <div class="card-header">
            <h3 class="card-title">{{ _i('Categories') }} </h3>
        </div>

        <div class="card-body">

            <div class="" id="container">
                <div class="filter-product-checkboxs">

                    @foreach ($projcategory as $category)
                        @php
                            draw($category, $filter_category);
                        @endphp
                    @endforeach


                </div>
            </div>
        </div>
        <div class="card-header border-top">
            <h3 class="card-title">{{ _i('Price Range') }}</h3>
        </div>
        <div class="card-body">
            <h6>
                <label for="price">{{ _i('Price Range') }}:</label>
                <input type="text" id="price" name="range">
            </h6>
            <div id="mySlider"></div>
        </div>
        <div class="card-header border-top">
            <h3 class="card-title">{{ _i('type') }}</h3>
        </div>
        <div class="card-body">
            <div class="filter-product-checkboxs">

                <label class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" name="type" value="service">
                    <span class="custom-control-label">
                        {{ _i('Service') }}
                    </span>
                </label>
                <label class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" name="type" value="project">
                    <span class="custom-control-label">
                        {{ _i('Project') }}
                    </span>
                </label>
                <label class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" name="checkbox2" value="product">
                    <span class="custom-control-label">
                        {{ _i('Product') }}
                    </span>
                </label>
            </div>
        </div>


        <div class="card-footer">
            <button type="button" class="btn btn-secondary btn-block" id="btn_filter">{{ _i('Apply Filter') }}</button>
        </div>
    </div>

</form>
@push('css')
    <link href="{{ asset('website2/assets/plugins/jquery-uislider/jquery-ui.css') }}" rel="stylesheet">
@endpush

