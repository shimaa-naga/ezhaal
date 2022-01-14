<!-- Dashboard js -->
<script src="{{asset('website2/assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('website2/assets/plugins/bootstrap-4.1.3/popper.min.js')}}"></script>
<script src="{{asset('website2/assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js')}}"></script>
<script src="{{asset('website2/assets/js/vendors/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('website2/assets/js/vendors/selectize.min.js')}}"></script>
<script src="{{asset('website2/assets/js/vendors/jquery.tablesorter.min.js')}}"></script>
<script src="{{asset('website2/assets/js/vendors/circle-progress.min.js')}}"></script>
<script src="{{asset('website2/assets/plugins/rating/jquery.rating-stars.js')}}"></script>

<!-- Fullside-menu Js-->
<script src="{{asset('website2/assets/plugins/toggle-sidebar/sidemenu.js')}}"></script>
<!---Tabs JS-->
<script src="{{asset('website2/assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{asset('website2/assets/js/tabs.js')}}"></script>

<!-- Data tables -->
<script src="{{asset('website2/assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('website2/assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('website2/assets/js/datatable.js')}}"></script>


<!-- P-scroll js-->
<script src="{{asset('website2/assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>

@if(\App\Help\Utility::getLangCode() == 'ar')
    <script src="{{asset('website2/assets/plugins/p-scrollbar/p-scroll1-rtl.js')}}"></script>
@else
    <script src="{{asset('website2/assets/plugins/p-scrollbar/p-scroll1.js')}}"></script>
@endif

    <!--Counters -->
<script src="{{asset('website2/assets/plugins/counters/counterup.min.js')}}"></script>
<script src="{{asset('website2/assets/plugins/counters/waypoints.min.js')}}"></script>
<script src="{{asset('website2/assets/plugins/counters/numeric-counter.js')}}"></script>

<!-- Custom Js-->
<script src="{{asset('website2/assets/js/admin-custom.js')}}"></script>


<!------------------increased scripts ---->
<!-- CK Editor -->
<script src="{{ asset('custom/ckeditor/ckeditor.js') }}"></script>
<!---- added text color & background  and browse image --->
<script src="{{ asset('custom/parsley.min.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
<script>
    $(document).ready(function() {
        window.ParsleyValidator
            .addValidator('fileextension', function(value, requirement) {
                arr = value.split('.').pop().split("|");

                var fileExtension = value.split('.').pop();

                if (arr.indexOf(fileExtension) > -1)
                    return true;
                return false;
                //return fileExtension === requirement;
            }, 32)
            .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');
    });

</script>
@stack('js')
