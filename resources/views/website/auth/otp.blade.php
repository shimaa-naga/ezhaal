{{-- <div class="col-xl-6 col-md-6 col-md-6 "> --}}
    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="home-tab">
        <form class="login-form php-email-form" id="otp_frm" method="post" action="" data-parsley-validate="">
            @csrf

            <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title">{{ _i('OTP Login') }}</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        {{-- <label class="form-label text-dark">{{ _i('Mobile Number') }}</label> --}}
                        <input type="text" id="otp_mobile" class="form-control" name="otp_mobile" required=""
                            value="{{ old('otp_mobile') }}" placeholder="{{ _i('Mobile Number') }}">
                    </div>

                    <div class="form-footer mt-2">

                        <button type="submit" class="btn btn-primary btn-block">{{ _i('Send OTP') }}</button>
                    </div>


                </div>
            </div>
        </form>
        <form class="login-form php-email-form " style="display: none" id="otp_frm_verify" method="post" action="/otp_verify" data-parsley-validate="">
            @csrf

            <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title">{{ _i('Verify OTP') }}</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">

                        <input type="text" id="otp_code" class="form-control" name="otp_code" required=""
                            value="{{ old('otp_code') }}" placeholder="{{ _i('OTP code') }}">
                    </div>

                    <div class="form-footer mt-2">

                        <input type="hidden" name="otp_mobile" id="otp_mobile2">
                        <button type="submit" class="btn btn-primary btn-block">{{ _i('Login') }}</button>
                    </div>


                </div>
            </div>
        </form>
    </div>
{{-- </div> --}}

@push('js')
    <script>
        $(function() {
            $('#otp_frm').submit(function(e) {
                e.preventDefault();
                $.ajax({

                    url: "{{url('/otp')}}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response.status==false){
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: response.data,
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                        else
                        {
                            $("#otp_mobile2").val($("#otp_mobile").val());
                            $("#otp_frm").hide();
                            $("#otp_frm_verify").show();
                        }

                    }
                });
            });// otp_form


        });
    </script>
@endpush
