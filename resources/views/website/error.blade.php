@extends('website.layout.index', ['title' => _i("Error"),'header_title' => _i("Error")])
@section('content')
    <div class="row">
        @if ($errors->all())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    </div>

@endsection
