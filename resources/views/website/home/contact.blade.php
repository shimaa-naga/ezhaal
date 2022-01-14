<!-- ======= Contact Section ======= -->
<section id="contact" class="sptb">
    <div class="container">
        <div class="section-title center-block text-center">
            <h1>{{ _i('Contact Us') }}</h1>
{{--            <p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>--}}
        </div>
    </div>
    <div class="item-all-cat center-block text-center books-categories" id="container2">


        <div class="">
            <iframe style="border:0; width: 100%; height: 350px;"
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    <div class="container">

        <div class="info-wrap mt-5">
            <div class="row">
                <div class="col-lg-4 info">
                    <i class="ri-map-pin-line"></i>
                    <h4>Location:</h4>
                    <p>A108 Adam Street<br>New York, NY 535022</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                    <i class="ri-mail-line"></i>
                    <h4>Email:</h4>
                    <p>info@example.com<br>contact@example.com</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                    <i class="ri-phone-line"></i>
                    <h4>Call:</h4>
                    <p>+1 5589 55488 51<br>+1 5589 22475 14</p>
                </div>
            </div>
        </div>

        <form action="{{ route('website.contact.store') }}" method="post" data-parsley-validate="" role="form"
            class="php-email-form">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    @php
                        $auth_user = auth()
                            ->guard('web')
                            ->user();
                    @endphp
                    <input type="text" class="form-control" name="name" id="name" required=""
                        placeholder="{{ _i('Your Name') }}" maxlength="150" data-parsley-maxlength="150" minlength="3"
                        data-parsley-minlength="3"
                        value="{{ $auth_user ? $auth_user->name . ' ' . $auth_user->last_name : old('name') }}">
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input type="email" class="form-control" placeholder="{{ _i('Your Email') }}" name="email"
                        id="email" required="" data-parsley-type="email" maxlength="100" data-parsley-maxlength="100"
                        value="{{ $auth_user ? $auth_user->email : old('email') }}">
                </div>
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="{{ _i('Subject') }}"
                    required="" maxlength="255" data-parsley-maxlength="255">
            </div>
            <div class="form-group mt-3">
                <textarea class="form-control" rows="5" name="message" placeholder="{{ _i('Message') }}" required=""
                    minlength="10" data-parsley-minlength="10"></textarea>
            </div>
{{--            <div class="my-3">--}}
{{--                <div class="loading">{{ _i('Loading') }}</div>--}}
{{--                <div class="error-message"></div>--}}
{{--                <div class="sent-message">{{ _i('Your message has been sent. Thank you') }}!</div>--}}
{{--            </div>--}}
            <div class="text-center"><button type="submit" class="btn btn-primary">{{ _i('Send Message') }}</button></div>
        </form>

    </div>
</section><!-- End Contact Section -->
