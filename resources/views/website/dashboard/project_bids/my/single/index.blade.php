<div class="row">
    <div class="col-md-4">
        <form action="{{ url('dash/bid_work/store') }}/{{ $bid->id }}" method="POST" data-parsley-validate=""
            enctype="multipart/form-data">
            @csrf {{ method_field('POST') }}


            <div class="form-group row">

                <div class="col-sm-12">
                    {{ _i('Upload your work') }}
                    <input type="file" name="upload">
                </div>
            </div>
            <div class="form-group row">

                <div class="col-sm-12">
                    <textarea placeholder="{{ _i('work description') }}" name="desc" id="desc" class="form-control"
                        required></textarea>
                </div>
            </div>

            <div class=" row">

                <button type="submit" class="btn btn-primary">{{ _i('Send') }}</button>
            </div>
        </form>
        <p>
        </p>
        <form action="{{ url('dash/bid_work/complete') }}/{{ $bid->id }}" method="POST" >
            @csrf {{ method_field('POST') }}
                    <div class=" row">

                <button type="submit" class="btn btn-danger">{{ _i('Complete') }}</button>
            </div>
        </form>
    </div>
    <div class="col-md-8">
@include("website.dashboard.project_bids.my.single.attachments")
    </div>
</div>
