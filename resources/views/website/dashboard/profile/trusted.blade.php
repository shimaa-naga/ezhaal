@extends('website.layout.index', ['title' => _i('Skills'),'header_title' => _i('Skills')])
@section('content')
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    @include('website.dashboard.profile.profile_nav')

                    <div class="col-lg-9">
                        <div class="portfolio-info">
                            <form method="POST" action="{{ url('account/trusted') }}" data-parsley-validate=""
                                enctype="multipart/form-data">
                                <h3>
                                    {{ _i('Become Trusted') }} @if(auth("web")->user()->account_type==\App\Help\Constants\UserType::COMPANY) {{_i("Institution")}} @else {{_i("User")}} @endif
                                </h3>
                                @csrf
                                <?php   $file = \App\Help\Settings::GetNdaFile(); ?>
                                <a href=" {{ route('downloadTrusted', ['file' => basename($file)]) }}"
                                    target="win-{{ basename($file) }}">{{ basename($file) }}
                                </a>
                                <div class="form-group ">
                                    <label for="">{{ _i('Upload signed file') }}</label>
                                    <input type="file" class="form-control" id="inputGroupFile02" name="sign" required>
                                </div>
                                <button type="submit" class="btn btn-primary col-lg-3">
                                    {{ _i('Send') }} <i class="fa fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Content section End -->
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('custom/select2/css/select2.min.css') }}" />
@endpush
@push('js')
    <script type="text/javascript" src="{{ asset('custom/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-multiple").select2();
        });

    </script>
@endpush
