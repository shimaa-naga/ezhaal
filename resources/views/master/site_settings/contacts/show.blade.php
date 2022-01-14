@extends('master.layout.index' ,['title' => _i('Contact Details')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Contact Details') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Contact Details') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->
    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{_i('Contact no.')}} : <span class="text-muted">{{$contact->id}}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{_i('Contact date')}}: <span class="text-muted">{{$contact['created_at']}}</span>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('master.contact.destroy', $contact->id) }}" >
                        @csrf
                        @method('DELETE')

                        <div class="form-group">
                            <label for="user">{{_i('Contact User')}} :</label>
                            <input type="text" class="form-control" id="user" value="{{$contact['name']}}" readonly  >
                        </div>
                        <div class="form-group">
                            <label for="title">{{_i('Contact Email')}} :</label>
                            <input type="text" class="form-control"  value="{{$contact['email']}}" readonly  >
                        </div>
                        <div class="form-group">
                            <label for="title">{{_i('Subject')}} :</label>
                            <input type="text" class="form-control"  value="{{$contact['subject']}}" disabled >
                        </div>
                        <div class="form-group">
                            <label for="description">{{_i('Message')}} :</label>
                            <textarea  class="form-control" id="description" rows="7" disabled >{{$contact['message']}}</textarea>
                        </div>

                        <div class="box-footer">
                            <a class="btn btn-default col-sm-4" href="{{route('master.contact.index')}}"><i class="fa fa-long-arrow-left"></i> {{_i('Back')}}</a>
                            <button type="submit" class="btn btn-danger col-sm-4"><i class="fa fa-trash-o"></i> {{ _i('Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->
@endsection



