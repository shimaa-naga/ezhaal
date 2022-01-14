<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e438dcf702f3303"></script>

<script src="{{ asset('website2/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

<!-- Bootstrap js -->
<script src="{{ asset('website2/assets/plugins/bootstrap-4.1.3/popper.min.js') }}"></script>
<script src="{{ asset('website2/assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js') }}"></script>

<!--JQuery Sparkline Js-->
<script src="{{ asset('website2/assets/js/vendors/jquery.sparkline.min.js') }}"></script>

<!-- Circle Progress Js-->
<script src="{{ asset('website2/assets/js/vendors/circle-progress.min.js') }}"></script>

<!-- Star Rating Js-->
<script src="{{ asset('website2/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!--Owl Carousel js -->
<script src="{{ asset('website2/assets/plugins/owl-carousel/owl.carousel.js') }}"></script>

<!--Horizontal Menu-->
<script src="{{ asset('website2/assets/plugins/Horizontal2/Horizontal-menu/horizontal.js') }}"></script>

<!-- Datepicker js -->
<script src="{{ asset('website2/assets/plugins/date-picker/spectrum.js') }}"></script>
<script src="{{ asset('website2/assets/plugins/date-picker/jquery-ui.js') }}"></script>
<script src="{{ asset('website2/assets/plugins/date-picker/datepicker.js') }}"></script>

<!--JQuery TouchSwipe js-->
<script src="{{ asset('website2/assets/js/jquery.touchSwipe.min.js') }}"></script>

<!--Counters -->
<script src="{{ asset('website2/assets/plugins/count-down/countdown-timer.js') }}"></script>
<script src="{{ asset('website2/assets/plugins/count-down/countdown.js') }}"></script>

<!-- Showmore Js-->
<script src="{{ asset('website2/assets/js/jquery.showmore.js') }}"></script>

<script src="{{ asset('website2/assets/js/showmore.js') }}"></script>

<!--Select2 js -->
<script src="{{ asset('website2/assets/plugins/select2/select2.full.min.js') }}"></script>

<!-- Cookie js -->
<script src="{{ asset('website2/assets/plugins/cookie/jquery.ihavecookies.js') }}"></script>
<script src="{{ asset('website2/assets/plugins/cookie/cookie.js') }}"></script>

<!-- Custom scroll bar Js-->
<script src="{{ asset('website2/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

<!-- sticky Js-->
<script src="{{ asset('website2/assets/js/sticky.js') }}"></script>
<script src="{{ asset('website2/assets/js/custom-sticky.js') }}"></script>


<!-- Custom Js-->
<script src="{{ asset('website2/assets/js/custom.js') }}"></script>
<script src="{{ asset('website2/assets/js' . $dir . '/owl-carousel.js') }}"></script>


<script src="{{ asset('website2/assets/js' . $dir . '/custom2.js') }}"></script>
<script src="{{ asset('website2/assets/js/select2.js') }}"></script>
<script src="{{ asset('website2/assets/js/swipe.js') }}"></script>


<script src="{{ asset('custom/parsley.min.js') }}"></script>
<script src="{{ asset('custom/noty/noty.min.js') }}"></script>
<script src="{{ asset('master/assets/plugins/fileuploads/js/dropify.js') }}"></script>

{{-- <script> --}}
{{-- // jQuery.noConflict(); --}}
{{-- // $(function(){ --}}
{{-- //     $.noConflict(); --}}
{{-- // }) --}}

<script>
    $(function(){
        $('.dropify').dropify({
                    messages: {
                        'default': "{{ _i('Drag and drop a file here or click') }}",
                        'replace': "{{ _i('Drag and drop or click to replace') }}",
                        'remove': "{{ _i('Remove') }}",
                        'error': "{{ _i('Ooops, something wrong appended.') }}"
                    },
                    error: {
                        'fileSize': "{{ _i('The file size is too big (2M max).') }}"
                    }
                });
    });
</script>
@stack('js')
