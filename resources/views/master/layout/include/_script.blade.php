<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ asset('master/js/jquery.js') }}"></script>
<script type="text/javascript" language="javascript"
    src="{{ asset('master/assets/advanced-datatable/media/js/jquery.js') }}"></script>

<script src="{{ asset('master/js/bootstrap.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('master/js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('master/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('master/js/jquery.nicescroll.js') }}" type="text/javascript"></script>

<script type="text/javascript" language="javascript"
    src="{{ asset('master/assets/advanced-datatable/media/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('master/assets/data-tables/DT_bootstrap.js') }}"></script>
<!--downloaded datatable script-->
<script src="{{ asset('custom/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('custom/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('master/js/respond.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('master/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('master/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}">
</script>
<script type="text/javascript" src="{{ asset('master/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}">
</script>

<!--common script for all pages-->
<script src="{{ asset('master/js/common-scripts.js') }}"></script>

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
