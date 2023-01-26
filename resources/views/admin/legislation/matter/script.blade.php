<script>
    $(function() {

        $('#edit-modal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget), // Button that triggered the modal
                id = button.data('id');

            $.get('/admin/legislation/matter/' + id + '/edit', function(data) {
                $('#ajax-modal-body').html(data);
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
                message: 'Apakah Anda yakin menghapus data Urusan Pemerintahan <strong>' + name + '</strong>?',
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

    })
</script>
