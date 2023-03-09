<script>
    $(function() {

        $('.select-search').select2();

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });

        $(document).on('keypress', '.filter-form :input', function(e) {
            if (e.which == 13) {
                $('.filter-form').submit();
            }
        })

        $(document).on('change', '.filter-form :input', function(e) {
            $('.filter-form').submit();
        })

        $(document).on('click', '.copy-link', function(){
            let url = $(this).data('url');
            navigator.clipboard.writeText(url);

            confirm('URL telah berhasil disalin');
        })

        const value = document.querySelector("#value")
        const input = document.querySelector("#year")
        if (!!value) {
            value.textContent = input.value
            input.addEventListener("input", (event) => {
                value.textContent = event.target.value
            })
        }

        $('.options-hide-toggle').click(function() {
            let target = $(this).data('target');
            let el = $(this);
            $('#' + target).slideToggle('fast', function(){
                if (el.html() == 'Lihat semua') {
                    el.html('Lihat lebih sedikit');
                } else {
                    el.html('Lihat semua');
                }
            });
        })

        if ($().daterangepicker) {
            $('.daterange-datemenu').daterangepicker({
                showDropdowns: true,
                applyButtonClasses: "btn-danger",
                autoUpdateInput: false,
                locale: {
                    format: 'DD/MM/YYYY',
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

            $('.daterange-datemenu').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.daterange-datemenu').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        }
    });
</script>
