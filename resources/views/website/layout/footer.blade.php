

<!--Footer Section-->
<section>
    <footer class="bg-dark text-white">
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    @foreach(\App\Help\Utility::getFooter() as $footer)
                    @if($footer->order == 1)
                         <div class="col-lg-3 col-md-6">
                           <div class="footer-info">
                             <h3>{{$footer->Lang()->title}}</h3>

                             <p>
                               {!!  $footer->Lang()->content !!}
                               <strong>{{_i("Phone")}} : </strong>{{\App\Help\Settings::get('phone','')}}<br>
                               <strong>{{_i("Email")}} : </strong> {{\App\Help\Settings::get('email','')}}<br>
                             </p>
                             <div class="social-links mt-3">
                               <a href="{{\App\Help\Settings::get('twitter','#')}}" class="twitter"><i class="bx bxl-twitter"></i></a>
                               <a href="{{\App\Help\Settings::get('facebook','#')}}" class="facebook"><i class="bx bxl-facebook"></i></a>
                               <a href="{{\App\Help\Settings::get('instagram','#')}}" class="instagram"><i class="bx bxl-instagram"></i></a>
                               {{-- <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a> --}}
                               <a href="{{\App\Help\Settings::get('linkedin','#')}}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                             </div>
                           </div>
                         </div>
                    @else
                           <div class="col-lg-2 col-md-6 footer-links">
                               <h4>{{$footer->Lang()->title}}</h4>
                               <p>{!!  $footer->Lang()->content !!}</p>
                           </div>
                    @endif
                 @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark text-white p-0">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-lg-8 col-sm-12  mt-2 mb-2 text-{{\App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left'}} ">
                        Copyright © 2019 <a href="#" class="fs-14 text-primary">Pinlist</a>. Designed by <a href="#" class="fs-14 text-primary">Spruko</a> All rights reserved.
                    </div>
                    <div class="col-lg-4 col-sm-12 m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-auto mb-2 mt-2">
                        <ul class="social mb-0">
                            <li>
                                <a class="social-icon" href=""><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a class="social-icon" href=""><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a class="social-icon" href=""><i class="fa fa-rss"></i></a>
                            </li>
                            <li>
                                <a class="social-icon" href=""><i class="fa fa-youtube"></i></a>
                            </li>
                            <li>
                                <a class="social-icon" href=""><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a class="social-icon" href=""><i class="fa fa-google-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark text-white p-0 border-top">
            <div class="container">
                <div class="p-2 text-center footer-links">
                    <a href="#" class="btn btn-link">How It Works</a>
                    <a href="#" class="btn btn-link">About Us</a>
                    <a href="#" class="btn btn-link">Pricing</a>
                    <a href="#" class="btn btn-link">Ads Categories</a>
                    <a href="#" class="btn btn-link">Privacy Policy</a>
                    <a href="#" class="btn btn-link">Terms Of Conditions</a>
                    <a href="#" class="btn btn-link">Blog</a>
                    <a href="#" class="btn btn-link">Contact Us</a>
                    <a href="#" class="btn btn-link">Premium Ad</a>
                </div>
            </div>
        </div>
    </footer>
</section>
<!--Footer Section-->


