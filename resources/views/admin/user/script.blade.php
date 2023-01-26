<script>
    $(function() {

        $('.select-search').select2();

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        if ($().daterangepicker) {
            $('.daterange-single').daterangepicker({
                parentEl: '.content-inner',
                autoApply: true,
                singleDatePicker: true,
                autoUpdateInput: false,
                applyButtonClasses : 'btn-indigo',
                locale: {
                    format: 'DD-MM-YYYY',
                    applyLabel: "Ok",
                    cancelLabel: "Batal",
                    fromLabel: "Dari",
                    toLabel: "Ke",
                    daysOfWeek: [
                        "Mg",
                        "Sn",
                        "Sl",
                        "Rb",
                        "Km",
                        "Jm",
                        "Sb"
                    ],
                    monthNames: [
                        "Januari",
                        "Februari",
                        "Maret",
                        "April",
                        "Mei",
                        "Juni",
                        "Juli",
                        "Agustus",
                        "September",
                        "Oktober",
                        "November",
                        "Desember"
                    ],
                }
            });

            $('.daterange-single').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });

            $('.daterange-single').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        }

        if ($().finderSelect) {
            new findData();
        }

        $(document).on('click', '.trigger', function() {
            let items  = new collect_data(),
                action = $(this).data('action'),
                val    = $(this).data('val');

            if (action === 'delete') {
                bootbox.confirm({
                    title: 'Konfirmasi Perintah',
                    message: 'Apakah Anda yakin ingin menghapus operator?',
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
                            triggerAction(items, action, val);
                        }
                    }
                });
            } else {
                triggerAction(items, action, val);
            }
        })

        $('.export').click(function() {

            let el    = $(this).attr('href'),
                order = '',
                items = new collect_data();

            const params = new URLSearchParams(window.location.search);
            if (params.has('order')) {
                order = '&order=' + params.get('order') + '&sort=' + params.get('sort');
            }

            $(this).attr('href', el + '?id=' + items + order);
            console.log($(this).attr('href'));
        })

        $('.delete-form').submit(function(e) {
            e.preventDefault();

            let form = $(this);

            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: 'Apakah Anda yakin ingin menghapus operator?',
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
                        const [key, value] = entry;
                        form.find('#' + key).addClass('is-invalid');
                        form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                    });
                } else {
                    location.reload();
                }
            });
        })

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

        $(document).on('click', '#update-new-password', function() {

            let form = $(this).parent().parent();

            $.ajax({
                url : form.attr('action'),
                method: 'PUT',
                data: form.serialize(),
                dataType: 'json'
            }).fail(function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.entries(errors).forEach((entry) => {
                        const [key, value] = entry;
                        form.find('#' + key).addClass('is-invalid');
                        form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                    });
                } else {
                    location.reload();
                }
            });
        })

        $('#show-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id'),
                name  = button.data('name');

            $(this).find('.modal-title').html(name);

            $.ajax({
                url: '/admin/user/' + id,
                method: 'GET',
                beforeSend: function() {
                    $('#ajax-modal-content').html('<div class="modal-body">loading...</div>');
                }
            }).done(function(data) {
                $('#ajax-modal-content').html(data);
                $('[data-popup="tooltip"]').tooltip({
                    boundary: '.page-content'
                });
            });
        });

        $("#customFile").change(function() {
            readURL(this);
        });

        $('#filter').click(function() {
            $('#filter-options').slideToggle('fast');
        })

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });
    })

    function triggerAction(items, action, val) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/admin/user/trigger',
            method: 'POST',
            data: {'items':items, 'action': action, 'val': val}
        }).done(function(){
            location.reload();
        })
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
</script>
