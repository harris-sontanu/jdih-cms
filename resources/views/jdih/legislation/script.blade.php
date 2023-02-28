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

        $(document).on('click', '.copy-link', function(){
            let url = $(this).data('url');
            navigator.clipboard.writeText(url);

            confirm('URL telah berhasil disalin');
        })

    });
</script>
