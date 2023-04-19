<script>
    $(function() {

        if ($().select2) {
            $('.select').select2({
                minimumResultsForSearch: Infinity
            });
        }

        if ($().finderSelect) {
            new findData();
        }

        $(document).on('click', '.trigger', function() {
            let items  = new collect_data(),
                route  = $(this).data('route'),
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
                            triggerAction(items, route, action, val);
                        }
                    }
                });
            } else {
                triggerAction(items, route, action, val);
            }
        })

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
            let button = $(event.relatedTarget), // Button that triggered the modal
                id = button.data('id');

            $.get('/admin/employee/group/' + id + '/edit', function(data) {
                $('#ajax-modal-body').html(data);
            })
        });

        $(document).on('submit', '#update-group-form', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                url : form.attr('action'),
                method: 'PUT',
                data: form.serialize(),
            }).done(function() {
                location.reload();
            }).fail(function(response) {
                let errors = response.responseJSON.errors;
                Object.entries(errors).forEach((entry) => {                
                    let [key, value] = entry;
                    if (key == 'slug') { key = 'name'; }
                    form.find('#' + key).addClass('is-invalid');
                    form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                })
            });
        })

        $('#filter').click(function() {
            $('#filter-options').slideToggle('fast');
        })

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });

        if (typeof(Sortable) !== 'undefined') {
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
                            url: '/admin/employee/order-update',
                            method: 'POST',
                            data: {'orders': orders}
                        })
                    }
                }
            });
        }

        $('#show-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id');

            $.ajax({
                url: '/admin/employee/' + id,
                method: 'GET',
                beforeSend: function() {
                    $('#ajax-modal-content').html('<div class="modal-body">loading...</div>');
                }
            }).done(function(data) {
                $('#ajax-modal-content').html(data);
            });
        });

        $(document).on('change', '#avatar-input', function() {
            readURL(this);
        });

        $(document).on('click', '.remove-avatar', function(e) {
            e.preventDefault();

            let route = $(this).attr('href');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: route,
                method: "PUT"
            }).done(function() {
                location.reload();
            });
        })
    })

    function triggerAction(items, route, action, val) {
        console.log(route);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: route,
            method: 'POST',
            data: {'items':items, 'action': action, 'val': val}
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#avatar-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
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
</script>
