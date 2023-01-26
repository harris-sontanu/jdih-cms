<script>
    $(function() {

        $('.select').select2({
            dropdownParent: $('#create-modal'),
            minimumResultsForSearch: Infinity
        });

        $(document).on('click', '#save-btn', function() {

            let form = $(this).parent().parent();

            $.ajax({
                url : form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                dataType: 'json'
            }).fail(function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.entries(errors).forEach((entry) => {
                        let [key, value] = entry;
                        if (key == 'slug') { key = 'name'; }
                        form.find('#' + key).addClass('is-invalid');
                        form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                    });
                } else {
                    location.reload();
                }
            });
        })

        $('#edit-modal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget), // Button that triggered the modal
                id = button.data('id');

            $.get('/admin/legislation/category/' + id + '/edit', function(data) {
                $('#ajax-modal-body').html(data);
                $('.select').select2({
                    minimumResultsForSearch: Infinity
                });
            })
        });

        $(document).on('click', '#update-btn', function() {

            let form = $(this).parent().parent(),
                id   = $(this).data('id');

            $.ajax({
                url : form.attr('action'),
                method: 'PUT',
                data: form.serialize(),
                dataType: 'json'
            }).fail(function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.entries(errors).forEach((entry) => {
                        let [key, value] = entry;
                        if (key == 'slug') { key = 'name'; }
                        form.find('#' + key).addClass('is-invalid');
                        form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                    });
                } else {
                    location.reload();
                }
            });
        })

        $('.delete-form').submit(function(e) {
            e.preventDefault();

            let name = $(this).data('name'),
                form = $(this);

            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: 'Anda akan menghapus data jenis <strong>' + name + '</strong>. Segala data produk hukum yang dikelompokkan ke dalam jenis ini akan ikut terhapus. Apakah Anda yakin melakukan aksi ini?',
                buttons: {
                    confirm: {
                        label: 'Yakin',
                        className: 'btn-indigo'
                    },
                    cancel: {
                        label: 'Batal',
                        className: 'btn-link'
                    }
                },
                callback: function (result) {
                    if (result == true) {
                        form.unbind('submit').submit();
                    }
                }
            });
        })

        Sortable.create(sortable,{
            group: "category",
            handle: '.drag-handle',
            draggable: '.item',
            store: {
                get: function (sortable) {
                    return order = [];
                },

                set: function (sortable) {
                    var orders = sortable.toArray();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/admin/legislation/category/order-update',
                        method: 'POST',
                        data: {'orders': orders}
                    })
                }
            }
        });

    })
</script>
