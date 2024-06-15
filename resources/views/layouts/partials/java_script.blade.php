
 <!-- plugins:js -->
 <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 <!-- End plugin js for this page -->
 <!-- inject:js -->
 <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
 <script src="{{ asset('assets/js/misc.js') }}"></script>
 <script src="{{ asset('assets/js/settings.js') }}"></script>
 <script src="{{ asset('assets/js/todolist.js') }}"></script>
 <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
 <script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
 <!-- End plugin js for this page -->
 <!-- Custom js for this page -->
 <script src="{{ asset('assets/js/typeahead.js') }}"></script>
 <script src="{{ asset('assets/js/select2.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/file-upload.js') }}"></script>

<!-- Add Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
 
 <script>
     // Check for Laravel session flash messages
     @if (session('status'))
         @if (session('status.success') == '1')
             Swal.fire({
                 icon: 'success',
                 title: 'Success!',
                 text: '{{ session('success') }}',
             });
         @else
             Swal.fire({
                 icon: 'error',
                 title: 'Error!',
                 text: '{{ session('error') }}',
             });
         @endif
     @endif

     $(document).on('click', '.btn-modal', function(e) {
            e.preventDefault();
            var container = $(this).data('container');
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    console.log(result)
                    $(container).html(result);
                    $('#editModal').modal('show');
                },
            });
    });
      
    function closeModal() {
        $('.modal').modal('hide');
    }
    $(document).ready(function() {
        $('.ckeditor').each(function() {
            let placeholder = $(this).attr('placeholder');

            // Configuration for Summernote instance
            let usrCfg = {
                height: 200,
                placeholder: placeholder,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                width: '100%', // Adjust width as needed
            };

            // Initialize Summernote for the current textarea with usrCfg
            $(this).summernote(usrCfg);
        });
    });
</script>
@stack('js')
 <!-- endinject -->
 <!-- Custom js for this page -->
 <!-- End custom js for this page -->
