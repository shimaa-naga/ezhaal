<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _i('NDA') }}</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('master/trusted') }}" class="form-horizontal" id="demo-form"
              data-parsley-validate="" enctype="multipart/form-data">
            @csrf

            <?php
            $file = \App\Help\Settings::GetNdaFile();
            ?>
            <a href="{{ route('downloadTrusted', ['file' => basename($file)]) }}"
               target="win-{{ basename($file) }}">{{ basename($file) }}
            </a>
            <div class="form-group">
                <label for="" class="col-sm-4 col-form-label">{{ _i('Upload NDA file') }}</label>
                <div class="col-sm-12">
                    <input type="file" class="form-control" id="inputGroupFile02" name="sign" required>
                    {{ Str::replaceFirst(',', '|', \App\Help\Constants\MimTypes::NDA) }}
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-info col-sm-12">{{ _i('Save') }}</button>
            </div>
        </form>
    </div>
</div>

