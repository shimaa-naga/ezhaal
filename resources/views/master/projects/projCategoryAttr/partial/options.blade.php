<div class="col-sm-3">
    <button title="" data-original-title="down" class="btn btn-sm tooltips btn-primary" type="button"
        data-id="{{ $id }}" onclick="down(this)">
        <i class="fa fa-sort-down"></i></button>
    <button title="" type="button" data-id="{{ $id }}" data-original-title="up"
        class="btn btn-sm tooltips btn-primary" onclick="up(this)"><i class="fa fa-sort-up"></i></button>
    <button title="" type="button" data-original-title="Trash" class="btn btn-sm tooltips del btn-danger"
        onclick="deleteMe(this)" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        {{ _i('More') }}<span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" x-placement="bottom-start">
        <li><a
                href="javascript:ajaxGetData({{ \App\Help\Utility::getLang() }},{{ $id }})">{{ _i('Edit') }}</a>
        </li>
        @foreach (\App\Language::where('id', '!=', $trans->lang_id)->get() as $lang)
            <li><a href="javascript:ajaxGetData({{ $lang->id }},{{ $id }})">{{ $lang->title }}</a></li>
        @endforeach

    </ul>
</div>
