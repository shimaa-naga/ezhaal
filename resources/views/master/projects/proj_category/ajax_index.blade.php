<?php
function draw($category)
{
    if ($category->children()->count() != 0) {
        foreach ($category->children() as $item) {
            $img ="cat.png";
            $destinationPath = public_path("uploads/category/" . $item->id . ".png");
        if (file_exists($destinationPath))
            $img =$item->id.".png";
            ?>
<ol class="dd-list">
    <li class="dd-item" data-id="{{ $item->id }}">

        @php
            $data =$item->trans(LaravelGettext::getLocale()) ;
        @endphp
        <div class="dd-handle">{{ $data->title }}
            <?php
            $langs = App\Language::where('id', '!=', $data->lang_id)->get();
            $options = '';
            foreach ($langs as $lang) {
                $options .=
                    '
                            <li><a href="#" data-toggle="modal" data-target="#langedit" class="btn-xs lang_ex"
                                    data-categoryid="' .
                                    $item->id.
                    '" data-lang="' .
                    $lang->id .
                    '"  data-title="' .
                    $lang->title .
                    '">' .
                    $lang->title .
                    '</a></li>';
            }
            $html =
                '
                            <a href="' .
                $item->id .
                '/cat_attr" class="btn waves-effect waves-light btn-default  text-center btn-xs pull-right mx-2"
                                title="' .
                _i('Buy') .
                '">
                                <i class="fa fa-exchange"></i> </a>

                                <a href="' .
                $item->id .
                '/cat_attr?type=service" class="btn waves-effect waves-light btn-default  text-center btn-xs pull-right mx-2"
                                        title="' .
                _i('Sell') .
                '">
                                        <i class="fa fa-braille"></i> </a>
                            <a href="#" data-toggle="modal" data-target="#modal-edit"
                                class="btn-xs btn waves-effect waves-light btn-primary edit text-center pull-right mx-2" title="' .
                _i('Edit') .
                '" data-id="' .
                $item->id .
                '"   data-title="' .
                $data->title .
                '"  data-meta_keyword="' .
                $data->meta_keyword .
                '"  data-meta_description="' .
                $data->meta_description .
                '"  data-img_description="' .
                $data->img_description .
                '" data-type="' .
                $item->type .
                '" data-parent="' .
                $item->parent_id .
                '" data-publish="' .
                $item->published .
                '" data-img="'.$img.'" data-scope="' .
                $item->scope .
                '" >
                                <i class="fa fa-edit"></i></a>
                            <form class="delete  pull-right mx-2" action="' .
                route('master.proj_category.destroy', $item->id) .
                '" method="POST" style="display: inline-block; ">
                                <input name="_method" type="hidden" value="DELETE">
                                <input type="hidden" name="_token" value="' .
                csrf_token() .
                '">
                                <button type="submit" class="btn btn-danger btn-xs" title=" ' .
                _i('Delete') .
                ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                            </form> ';
            $html =
                $html .
                '
                            <div class="btn-group  pull-right mx-2">
                                <button type="button" class="btn btn-warning dropdown-toggle btn-xs" data-toggle="dropdown"
                                    title=" ' .
                _i('Translation') .
                ' ">
                                    <span class="fa fa-cogs"></span>
                                </button>
                                <ul role="menu" class="dropdown-menu">' .
                $options .
                '</ul>
                            </div>';
            echo $html;
            ?>
        </div>
        <?php draw($item); ?>


    </li>

</ol>
<?php

        }
    }
}

?>


@foreach ($parents as $item)
    <div class="col-lg-6">
        <section class="card">
            <div class="card-body">
                <div class="dd">
                    <ol class="dd-list">
                        <li class="dd-item" data-id="{{ $item->id }}">
                            @include("master.projects.proj_category.include.item")
                            @php
                                Draw($item);

                            @endphp
                        </li>
                    </ol>
                </div>
            </div>
        </section>
    </div>
@endforeach
<div class="col-lg-12">
    <div class="text-center">
        {!! $parents->links() !!}
    </div>
</div>
