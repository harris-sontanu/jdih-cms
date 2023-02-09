<script>
    $(function() {

        $('.select-search').select2({
            dropdownParent: $('#filter-dropdown-container')
        });

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

		$('#search-dropdown').on('keyup change', function() {
			let search 	= $(this).val(),
				dom		= $('#search-dropdown-results');

				console.log(search);

			if (search.length > 0) {
				$(this).dropdown('show');

				$.get('/admin/legislation/search', {search: search})
				.done(function(html){
					dom.html(html);
				});
			}
		})

		$('body').click(function() {
			$('#search-dropdown').dropdown('hide');
		})

    })
</script>