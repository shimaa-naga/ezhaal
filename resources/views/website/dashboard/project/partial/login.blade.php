<!-- Message Modal -->
<div class="modal fade" id="exampleModal3">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">{{ _i('Login') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-md-12 register-right">
                        <ul class="nav nav-tabs nav-justified  p-2 border" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active m-1" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">{{ _i('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link m-1" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">{{ _i('Register') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form method="POST" data-parsley-validate="" id="frm_login_first"
                                            action="{{ url('projects/store') }}">
                                            @csrf
                                            @include("website.dashboard.project.partial.login.form")
                                        </form>

                                    </div>
                                    <div class="col-md-6">
                                        @include("website.auth.otp")

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form method="POST" data-parsley-validate=""                                  action="{{ url('projects/store') }}">
                                    @csrf
                                    @include("website.dashboard.project.partial.login.register")
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none" id="prev_fields">
                </div>
            </div>



        </div>
    </div>
</div>
