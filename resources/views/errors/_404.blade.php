<!DOCTYPE html>
<html lang="en">
@include('website.layout.include.style')

<body>

    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="fixed-top d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:contact@example.com">contact@example.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
            </div>
            <div class="social-links d-none d-md-flex">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
            </div>
        </div>
    </section>

    <!-- ======= Header ======= -->
    @include('website.layout.header')
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    @yield('slider')

    <main id="main">

        <section class="inner-page">

            <div class="container">
                <section class="contact">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{_i("Home")}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{!empty($header_title)? $header_title : ""}}</li>
                        </ol>
                    </nav>
                    <div class="container">

                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-danger">
                                        <h2>
                                            Not Found | 404

                                            {{-- @dd($exception) --}}
                                            {{ $exception->getMessage() }}</h2>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </div>
        </section>

    </main><!-- End #main -->


    @include('website.layout.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>



 <!-- Vendor JS Files -->
 <script src="{{asset('website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <script src="{{asset('website/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
 <script src="{{asset('website/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
 {{-- <script src="{{asset('website/assets/vendor/php-email-form/validate.js')}}"></script> --}}
 <script src="{{asset('website/assets/vendor/purecounter/purecounter.js')}}"></script>
 <script src="{{asset('website/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

 <!-- Template Main JS File -->
 <script src="{{asset('website/assets/js/main.js')}}"></script>
 {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
 {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
 <script src="{{asset('website/assets/js/jquery-3.5.1.min.js')}}"></script>
 <script src="{{asset('website/assets/js/bootstrap.min.js')}}"></script>
</body>

</html>
