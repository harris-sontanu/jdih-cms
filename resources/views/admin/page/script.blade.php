<script>
    $(function() {

        if ($().select2) {
            $('.select').select2();
        }

        if ($().finderSelect) {
            new findData();
        }

        if (typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '[data-bs-popup="lightbox"]',
                loop: true,
            });
        }

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

        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.ClassicEditor.create(document.getElementById("ckeditor_body"), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'sourceEditing'
                    ],
                    // shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Ketik detail informasi halaman yang ingin disampaikan.',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    'MathType'
                ]
            });

            CKEDITOR.ClassicEditor.create(document.getElementById("ckeditor_excerpt"), {
                toolbar: ['bold', 'italic', 'link', 'undo', 'redo'],
                placeholder: 'Ketik bagian pembuka atau potongan singkat dari isi halaman.',
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    'MathType'
                ]
            });
        }

        if ($().fileinput) {

            // Buttons inside zoom modal
            const previewZoomButtonClasses = {
                rotate: 'btn btn-light btn-icon btn-sm',
                toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
                fullscreen: 'btn btn-light btn-icon btn-sm',
                borderless: 'btn btn-light btn-icon btn-sm',
                close: 'btn btn-light btn-icon btn-sm'
            };

            // Icons inside zoom modal classes
            const previewZoomButtonIcons = {
                prev: document.dir == 'rtl' ? '<i class="ph-arrow-right"></i>' : '<i class="ph-arrow-left"></i>',
                next: document.dir == 'rtl' ? '<i class="ph-arrow-left"></i>' : '<i class="ph-arrow-right"></i>',
                rotate: '<i class="ph-arrow-clockwise"></i>',
                toggleheader: '<i class="ph-arrows-down-up"></i>',
                fullscreen: '<i class="ph-corners-out"></i>',
                borderless: '<i class="ph-frame-corners"></i>',
                close: '<i class="ph-x"></i>'
            };

            // File actions
            const fileActionSettings = {
                zoomClass: '',
                zoomIcon: '<i class="ph-magnifying-glass-plus"></i>',
                dragClass: 'p-2',
                dragIcon: '<i class="ph-dots-six"></i>',
                removeClass: '',
                removeErrorClass: 'text-danger',
                removeIcon: '<i class="ph-trash"></i>',
                indicatorNew: '<i class="ph-file-plus text-success"></i>',
                indicatorSuccess: '<i class="ph-check file-icon-large text-success"></i>',
                indicatorError: '<i class="ph-x text-danger"></i>',
                indicatorLoading: '<i class="ph-spinner spinner text-muted"></i>'
            };

            $('.file-input').fileinput({
                browseLabel: 'Browse',
                browseIcon: '<i class="ph-file-plus me-2"></i>',
                uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
                removeIcon: '<i class="ph-x fs-base me-2"></i>',
                showUpload: false,
                layoutTemplates: {
                    icon: '<i class="ph-check"></i>'
                },
                uploadClass: 'btn btn-light',
                removeClass: 'btn btn-light',
                initialCaption: "No file selected",
                allowedFileExtensions : ['jpg', 'jpeg', 'gif', 'png'],
                maxFileSize: 2048,
                previewZoomButtonClasses: previewZoomButtonClasses,
                previewZoomButtonIcons: previewZoomButtonIcons,
                fileActionSettings: fileActionSettings
            });
        }

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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#cover-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
