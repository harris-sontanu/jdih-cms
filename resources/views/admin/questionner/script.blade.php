<script>
    $(function() {

        $('.select').select2();

        $('.delete-question-form').submit(function(e) {
            e.preventDefault();

            let form = $(this);

            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: 'Apakah Anda yakin ingin menghapus pertanyaan?',
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

        $(document).on('click', '.add-answer-option', function() {
            let sequence = $(this).data('sequence'),
                nextSequence = parseInt(sequence) + 1;
                dom      = $('.answer-option-list'),
                html     = '<div class="row mt-3"><label class="col-lg-1 col-form-label text-lg-end">'+ nextSequence +'.</label>';
                html    += '<div class="col-lg-11"><input type="text" name="newAnswers[]" class="form-control"></div></div>';
            
            dom.append(html);
            $(this).data('sequence', nextSequence);
        })

        $('#create-modal').on('show.bs.modal', function(event) {
            let button  = $(event.relatedTarget), // Button that triggered the modal
                type    = button.data('type');

            $('#question-type').val(type);
        })

        $(document).on('submit', '#store-question-form', function(e) {
            e.preventDefault();

            let form = $(this),
                url  = form.attr('action'),
                data = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                contentType: false,
                processData: false,
            }).done(function() {
                location.reload();
            }).fail(function(response) {
                let errors = response.responseJSON.errors;
                Object.entries(errors).forEach((entry) => {
                    const [key, value] = entry;
                    form.find('#' + key).addClass('is-invalid');
                    form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                });
            })
        })

        $(document).on('submit', '#update-question-form', function(e) {
            e.preventDefault();

            let form = $(this),
                url  = form.attr('action'),
                data = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                contentType: false,
                processData: false,
            }).done(function() {
                location.reload();
            }).fail(function(response) {
                let errors = response.responseJSON.errors;
                Object.entries(errors).forEach((entry) => {
                    const [key, value] = entry;
                    form.find('#' + key).addClass('is-invalid');
                    form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                });
            })
        })

        $('#edit-modal').on('show.bs.modal', function(event) {
            let button  = $(event.relatedTarget), // Button that triggered the modal
                id      = button.data('id');

            $.get('/admin/questionner/question/' + id + '/edit', function(html) {
                $('#ajax-modal-body').html(html);
            })
        })

        $(document).on('click', '.delete-answer', function() {
            let dom = $(this),
                id  = dom.data('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/admin/questionner/answer/' + id + '/destroy',
                method: 'DELETE'
            }).done(function() {
                dom.parent().parent().parent().remove();
            });
        })

    })
</script>
