<script>
    $(function() {

        if ($().select2) {
            $('.select').select2();
        }

        if ($().finderSelect) {
            new findData();
        }

        $(document).on('click', '.trigger', function() {
            let items  = new collect_data(),
                route  = $(this).data('route'),
                type   = $(this).data('type'),
                action = $(this).data('action'),
                val    = $(this).data('val');

            if (action === 'delete') {
                bootbox.confirm({
                    title: 'Konfirmasi Perintah',
                    message: $(this).data('confirm'),
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
                            triggerAction(items, route, type, action, val);
                        }
                    }
                });
            } else {
                triggerAction(items, route, type, action, val);
            }
        })

        if (typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '[data-lightbox="lightbox"]',
                loop: true,
            });
        }

        $('.delete-form').submit(function(e) {
            e.preventDefault();

            let form = $(this);

            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: form.data('confirm'),
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

        $('#edit-modal').on('show.bs.modal', function(event) {
            let button  = $(event.relatedTarget), // Button that triggered the modal
                id      = button.data('id'),
                route   = button.data('route');

            $.get('/admin/media/' + route + '/' + id + '/edit', function(html) {
                $('#ajax-modal-body').html(html);
            })
        })

        $(document).on('submit', '#store-image-form', function(e) {
            e.preventDefault();

            let form = $(this),
                formData = new FormData(this);

            new mediaUpload(form, formData);
        })

        $(document).on('submit', '.update-image-form', function(e) {
            e.preventDefault();

            let form = $(this),
                formData = new FormData(this);

            new mediaUpload(form, formData);
        })

        $(document).on('submit', '#store-file-form', function(e) {
            e.preventDefault();

            let form = $(this),
                formData = new FormData(this);

            new mediaUpload(form, formData);
        })

        $(document).on('submit', '.update-file-form', function(e) {
            e.preventDefault();

            let form = $(this),
                formData = new FormData(this);

            new mediaUpload(form, formData);
        })

        $(document).on('change', '.upload-img', function() {
            let id = $(this).data('id');
            readURL(this, id);
        });

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
                        url: '/admin/media/slide/order-update',
                        method: 'POST',
                        data: {'orders': orders}
                    })
                }
            }
        });

    })

    function mediaUpload(element, data) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: element.attr('action'),
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
                element.find('#' + key).addClass('is-invalid');
                element.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
            });
        })
    }

    function triggerAction(items, route, type, action, val) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: route,
            method: 'POST',
            data: {'items':items, 'type': type, 'action': action, 'val': val}
        }).done(function(){
            location.reload();
        })
    }

    function collect_data(){
        var array_item_id = [];
        $('.checkbox:checked').each(function() {
            array_item_id.push($(this).data('item'));
        });
        return array_item_id;
    }

    function findData(){

        // Initialise the Demo with the Ctrl Click Functionality as the Default
        var list = $('.table tbody').finderSelect({enableDesktopCtrlDefault:true, selectClass:'table-primary'});

        // Add a hook to the highlight function so that checkboxes in the selection are also checked.
        list.finderSelect('addHook','highlight:before', function(el) {
            el.find('input').prop('checked', true);
            $('#bulk-actions').show();
            let i = $('.table .checkbox:checked').length;
            $('#count-selected').html(i);
        });

        // Add a hook to the unHighlight function so that checkboxes in the selection are also unchecked.
        list.finderSelect('addHook','unHighlight:before', function(el) {
            el.find('input').prop('checked', false);
            let i = $('.table .checkbox:checked').length;
            if (i === 0) {
                $('#bulk-actions').hide();
            } else {
                $('#count-selected').html(i);
            }
        });

        // Add a Safe Zone to show not all child elements have to be active.
        $(".safezone").on("mousedown", function(e){
            return false;
        });

        // Prevent Checkboxes from being triggered twice when click on directly.
        list.on("click", "input[type='checkbox']", function(e){
            e.preventDefault();
        });

        // Add Select All functionality to the checkbox in the table header row.
        $('.table').find("thead input[type='checkbox']").change(function () {
            if ($(this).is(':checked')) {
                list.finderSelect('highlightAll');
                $('#bulk-actions').show();
                let i = $('.table .checkbox:checked').length;
                $('#count-selected').html(i);
            } else {
                list.finderSelect('unHighlightAll');
                $('#bulk-actions').hide();
            }
        });
    }

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader  = new FileReader();

            reader.onload = function(e) {
                $('#image-src-' + id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
