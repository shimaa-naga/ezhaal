@extends('master.layout.index' ,['title' => _i('Role Users')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Roles') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item " ><a href="{{url('master/roles')}}">{{ _i('Roles') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Role Users') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <div class="row">
        @foreach ($users as $user)
        <div class="col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <a class="pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} " href="#">
                            <img class="thumb media-object" src="{{asset('uploads/users/default.png')}}" width="100px" alt="">
                        </a>
                        <div class="media-body">
                            <h4><?=$user->name?> {{$user->last_name}} <span class="text-muted small"> - {{$user->email}}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection
