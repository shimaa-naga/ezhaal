
<form method="POST" class="form-horizontal" id="demo-form" data-parsley-validate=""
enctype="multipart/form-data">
@csrf
@method('PATCH')
<div class="form-group">
    <label for="" class="col-sm-2 col-form-label">
        {{ _i('Pay after') }} :
    </label>
    <div class="col-sm-10">
        {!! $date_info !!}
    </div>
</div>
<div class="form-group">
    <label for="" class="col-sm-4 col-form-label">{{ _i('Upload Statement file') }}</label>
    <div class="col-sm-12">
        <input type="file" class="form-control" name="statement" required>
        {{ Str::replaceFirst(',', '|', \App\Help\Constants\MimTypes::STATEMENT) }}
    </div>
</div>

<div class="box-footer">
    <button type="submit" class="btn btn-info col-sm-12">{{ _i('Save') }}</button>
</div>
</form>
