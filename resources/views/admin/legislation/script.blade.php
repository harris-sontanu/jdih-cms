<script>
    $(function() {

        $('.select-search').select2();

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        const daterangepickerConfig = {
            parentEl: '.content-inner',
            opens: 'left',
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
        }

        if ($().daterangepicker) {
            $('.daterange-single').daterangepicker(daterangepickerConfig);

            $('.daterange-single').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });

            $('.daterange-single').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            daterangepickerConfig.timePicker = true;
            daterangepickerConfig.timePicker24Hour = true;
            $('.datetimerange-single').daterangepicker(daterangepickerConfig);

            $('.datetimerange-single').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY HH:mm'));
            });

            $('.datetimerange-single').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
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

        $("#cover-input").change(function() {
            readURL(this);
        });

        $('#filter').click(function() {
            $('#filter-options').slideToggle('fast');
        })

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });

        $(document).on('click', '.new-attachment', function() {
            let html = '<input type="file" class="form-control mt-3" name="attachment[]" accept=".doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .zip, .rar, .rtf, .txt">';

            $(this).before(html);
        })

        $(document).on('click', '#save-matter-btn', function() {

            let form       = $(this).parent().parent(),
                selectedId = $('#matter').val();

            $.ajax({
                url : form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                dataType: 'json'
            }).fail(function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    form.find('#name').addClass('is-invalid');
                    Object.entries(errors).forEach((entry) => {
                        const [key, value] = entry;
                        form.find('#name').parent().append('<div class="invalid-feedback">' + value + '</div>');
                    });
                }
            }).done(function(response) {
                selectedId.push(response.id)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/admin/legislation/matter/select-options',
                    method: 'POST',
                    data: {'selectedId': selectedId}
                }).done(function(html) {
                    $('#matter-options').html(html);
                    $('#create-matter-modal').modal('hide');
                    $('.select').select2();
                })
            });
        })

        $(document).on('submit', '#insert-institute-form', function(e) {
            e.preventDefault();

            let form       = $(this);

            $.ajax({
                url : form.attr('action'),
                method: 'POST',
                data: form.serialize(),
            }).fail(function(response) {
                let errors = response.responseJSON.errors;
                form.find('#name').addClass('is-invalid');
                Object.entries(errors).forEach((entry) => {
                    const [key, value] = entry;
                    form.find('#name').parent().append('<div class="invalid-feedback">' + value + '</div>');
                });
            }).done(function(response) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/admin/legislation/institute/select-options',
                    method: 'POST',
                    data: {'selectedId': response.id}
                }).done(function(html) {
                    $('#institute-options').html(html);
                    $('#create-institute-modal').modal('hide');
                    $('.select').select2();
                })
            });
        })

        $(document).on('submit', '#insert-field-form', function(e) {
            e.preventDefault();

            let form       = $(this);

            $.ajax({
                url : form.attr('action'),
                method: 'POST',
                data: form.serialize(),
            }).fail(function(response) {
                let errors = response.responseJSON.errors;
                form.find('#name').addClass('is-invalid');
                Object.entries(errors).forEach((entry) => {
                    const [key, value] = entry;
                    form.find('#name').parent().append('<div class="invalid-feedback">' + value + '</div>');
                });
            }).done(function(response) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/admin/legislation/field/select-options',
                    method: 'POST',
                    data: {'selectedId': response.id}
                }).done(function(html) {
                    $('#field-options').html(html);
                    $('#create-field-modal').modal('hide');
                    $('.select').select2();
                })
            });
        })

        $('#add-relation-modal .select2').select2({
            dropdownParent: $('#add-relation-modal'),
            minimumResultsForSearch: Infinity
        });

        $('#add-relation-modal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget), // Button that triggered the modal
                title = button.data('title'),
                type  = button.data('type');

            $(this).find('.modal-title').html(title);
            $(this).find('#relationType').val(type);
            $('#statusOptions').val(null).trigger('change'); 
            $('#statusRelatedTo').val(null).trigger('change');            
            
            if (type === 'document') {
                $('#status-options-container').addClass('d-none');
                $('#statusRelatedTo').prev().html('Cari Monografi');
                $("#statusRelatedTo option:first").html('Cari Monografi');
                $('#statusRelatedTo').select2({
                    dropdownParent: $('#add-relation-modal'),
                    ajax: {
                        url: '/api/monographs',
                        data: function (params) {
                            var query = {
                                search: params.term,
                            }

                            return query;
                        },
                        processResults: function (results) {
                            return {
                                results: $.map(results.data, function (item) {
                                    return {
                                        text: item.judul,
                                        id: item.idData
                                    }
                                })
                            };
                        }
                    }
                });
            } else {
                $('#status-options-container').removeClass('d-none');
                $('#statusRelatedTo').prev().html('Cari Peraturan');
                $("#statusRelatedTo option:first").html('Cari Peraturan');
                $('#statusRelatedTo').select2({
                    dropdownParent: $('#add-relation-modal'),
                    ajax: {
                        url: '/api/laws',
                        data: function (params) {
                            var query = {
                                search: params.term,
                            }

                            return query;
                        },
                        processResults: function (results) {
                            return {
                                results: $.map(results.data, function (item) {
                                    return {
                                        text: item.judul,
                                        id: item.idData
                                    }
                                })
                            };
                        }
                    }
                });
            }
        });

        $(document).on('submit', '#update-document-form', function(e) {
            e.preventDefault();

            let form = $(this),
                formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
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

        $(document).on('click', '.delete-document', function() {
            let route = $(this).data('route');

            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: 'Apakah Anda yakin ingin menghapus dokumen?',
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
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: route,
                            method: 'DELETE'
                        }).done(function() {
                            location.reload();
                        })
                    }
                }
            });
        })

        $('#add-relationship-form').on('submit', function(e) {
            e.preventDefault();

            let relationType = $('#relationType').val(),
                tableBody = $('#'+relationType+'-relation-table-body'),
                sequence  = tableBody.find('.sequence').last(),
                form      = $(this);

            if (sequence.length > 0) {
                nextSequence = parseInt(sequence.html()) + 1;
            } else {
                nextSequence = 1;
            }

            tableBody.find('.table-warning').remove();

            $.ajax({
                url : form.attr('action'),
                method: 'POST',
                data: form.serialize() + '&sequence=' + nextSequence,
            }).fail(function(response) {
                let errors = response.responseJSON.errors;
                Object.entries(errors).forEach((entry) => {
                    const [key, value] = entry;
                    form.find('#' + key).addClass('is-invalid');
                    form.find('#' + key).parent().append('<div class="invalid-feedback">' + value + '</div>');
                });
            }).done(function(html) {
                tableBody.append(html);
                $('#add-relation-modal').modal('hide');
            })
        })

        $(document).on('click', '.unlink-relationship', function() {

            const dom   = $(this),
                  route = dom.data('route');

            if (route !== undefined) {
                let related = dom.data('related'),
                    type    = dom.data('type'),
                    status  = dom.data('status');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: route,
                    method: 'DELETE',
                    data: {type: type, status: status, relatedId: related}
                }).done(function() {
                    dom.parent().parent().remove();
                })
            } else {
                dom.parent().parent().remove();
            }
        })

    })

    function triggerAction(items, route, action, val) {
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#cover-img').attr('src', e.target.result);
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
