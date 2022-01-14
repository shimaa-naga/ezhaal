
@if (session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> <i class="fa fa-ok-sign"></i> {{ _i('Success') }}!</strong> {{ session('success') }}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> <i class="fa fa-ok-sign"></i> {{ _i('Error') }}!</strong> {{ session('error') }}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif

@if ($errors->all())
    <div class="alert alert-danger row">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
