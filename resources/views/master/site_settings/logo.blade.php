<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _i('Logo') }}</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('master/logo') }}" class="form-horizontal"
              data-parsley-validate="" enctype="multipart/form-data">
            @csrf

            <?php
            $file = \App\Help\Settings::GetLogo();

            ?>

            <div class="form-group">
                <div>
                    @if($file!="")
                        <img  class="col-sm-12" src="{{asset($file)}}">
                    @endif
                </div>

                <div class="col-sm-12">
                    <input type="file" class="form-control" id="inputGroupFile02" name="sign" >

                </div>
                <div class="col-sm-12">
                    <input type="checkbox"   name="del" > {{_i("Remove logo")}}

                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-info col-sm-12">{{ _i('Save') }}</button>
            </div>
        </form>

    </div>
</div>

