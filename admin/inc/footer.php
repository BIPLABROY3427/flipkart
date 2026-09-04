</div>
<script src="assets/admin/js/vendor/grid.min.js"></script>
<!-- bootstrap-toggle js -->
<script src="assets/admin/js/vendor/bootstrap-toggle.min.js"></script>
<!-- slimscroll js for custom scrollbar -->
<script src="assets/admin/js/vendor/jquery.slimscroll.min.js"></script>
<!-- custom select box js -->
<script src="assets/admin/js/vendor/jquery.nice-select.min.js"></script>
<link rel="stylesheet" href="assets/global/css/iziToast.min.css" />
<script src="assets/global/js/iziToast.min.js"></script>
<script>
    "use strict";

    function notify(status, message) {
        iziToast[status]({
            message: message,
            position: "topRight",
        });
    }
</script>
<!-- seldct 2 js -->
<script src="assets/admin/js/vendor/select2.min.js"></script>
<script src="assets/admin/js/nicEdit.js"></script>
<script src="assets/admin/js/app.js"></script>
<script src="assets/DataTables/dataTables.min.js"></script>
<script src="assets/DataTables/DataTables-1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/admin/js/parsley.js"></script>
<script src="assets/admin/js/bootstrap-iconpicker.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
<script>
    $(document).ready(function() {
        // Only initialize generic #example table if it exists and not productTable page
        if ($('#example').length && !$('#productTable').length) {
            $('#example').DataTable({
                responsive: true
            });
        }
    });
</script>
<script>
    $(function() {
        setTimeout(function() {
            $("#hide-toast").fadeOut(1500);
        }, 5000)

    });
</script>
<script>
    $(document).ready(function() {
        $('.nicEdit').summernote();
    });
</script>
<script>
    $(function() {
        $('input[name=meta_keyword]')
            .on('change', function(event) {
                var $element = $(event.target);
                var $container = $element.closest('.example');

                if (!$element.data('tagsinput')) return;

                var val = $element.val();
                if (val === null) val = 'null';
                var items = $element.tagsinput('items');

                $('code', $('pre.val', $container)).html(
                    $.isArray(val) ?
                    JSON.stringify(val) :
                    '"' + val.replace('"', '\\"') + '"'
                );
                $('code', $('pre.items', $container)).html(
                    JSON.stringify($element.tagsinput('items'))
                );
            })
            .trigger('change');
    });
</script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#time").load("get_time.php");
        }, 1000);
    });
</script>

<script>
    (function($) {
        "use strict";
        $('.removeBtn').on('click', function() {
            var modal = $('#removeModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });

        $('.addBtn').on('click', function() {
            var modal = $('#addModal');
            modal.modal('show');
        });

        $('.updateBtn').on('click', function() {
            var modal = $('#updateBtn');
            modal.find('input[name=id]').val($(this).data('id'));

            var obj = $(this).data('all');
            var images = $(this).data('images');
            if (images) {
                for (var i = 0; i < images.length; i++) {
                    var imgloc = images[i];
                    $(`.imageModalUpdate${i}`).css("background-image", "url(" + imgloc + ")");
                }
            }
            $.each(obj, function(index, value) {
                modal.find('[name=' + index + ']').val(value);
            });

            modal.modal('show');
        });

        $('#updateBtn').on('shown.bs.modal', function(e) {
            $(document).off('focusin.modal');
        });
        $('#addModal').on('shown.bs.modal', function(e) {
            $(document).off('focusin.modal');
        });

        $('.iconPicker').iconpicker().on('change', function(e) {
            $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
        });

        // Update Admin Index Rank via AJAX
        $(document).on('change', '.admin-index-input', function() {
            var id = $(this).data('id');
            var val = $(this).val();
            $.ajax({
                url: 'module/update-index.php',
                type: 'POST',
                data: {
                    id: id,
                    index_val: val
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        notify('success', 'Rank Index Updated successfully!');
                    } else {
                        notify('error', 'Error updating Rank Index!');
                    }
                }
            });
        });
    })(jQuery);
</script>
</body>

</html>
