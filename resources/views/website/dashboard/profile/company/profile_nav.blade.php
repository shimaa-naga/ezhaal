@php
    $user =auth("web")->user();
@endphp
<div class="col-lg-3 mb-3">

    <div class=" portfolio-info">
        <div class="nav">
            {{-- <div class="card-body"> --}}
            <div class="d-flex flex-column align-items-center text-center">
                <img alt="Admin" class="rounded-circle" width="150" height="150" src="@if ($user->image != null && file_exists(public_path($user->image))) {{ asset($user->image) }} @else {{ asset('uploads/users/user-default2.jpg') }} @endif">

                <div class="mt-3">
                    <h4>{{ $user->name . ' ' . $user->last_name }}</h4>
                    {{-- <p class="text-secondary mb-1">Full Stack Developer</p> --}}
                    <p class="text-muted font-size-sm">
                        {{ $user->country() != null ? $user->country()['title']." , " : '' }}
                        {{ $user->city() != null ? $user->city()['title'] : '' }}</p>
                    <hr>
                    <a class="nav-link" href="{{ route('website.profile.personal_info') }}">{{ _i('Edit account') }}
                        <i class="fa fa-external-link"></i></a>


                </div>
            </div>
        </div>
    </div> <br>
@include("website.dashboard.profile.company.sub_nav")


</div>
