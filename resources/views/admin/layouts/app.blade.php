<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-static">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', $appName)</title>

	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/admin/favicon/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/admin/favicon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/admin/favicon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('assets/admin/favicon/site.webmanifest') }}">

	<!-- Global stylesheets -->
	<link href="{{ asset('assets/admin/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/admin/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/admin/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet" type="text/css">
    @isset ($styles)
        @foreach ($styles as $style)
            <link href="{{ asset($style) }}" rel="stylesheet" type="text/css">
        @endforeach
    @endisset
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('assets/admin/demo/demo_configurator.js') }}"></script>
	<script src="{{ asset('assets/admin/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/admin/js/jquery/jquery.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	@isset($vendors)
        @foreach ($vendors as $vendor)
            <script src="{{ asset($vendor) }}"></script>
        @endforeach
    @endisset

	<script src="{{ asset('assets/admin/js/app.js') }}"></script>
    @yield('script')
	<!-- /theme JS files -->

	<script>
		$(function() {
			var $window = $(window),
				$html = $('#sidebar-main');

			function resize() {
				if ($window.width() > 960 && $window.width() < 1600) {
					return $html.addClass('sidebar-main-resized');
				}

				$html.removeClass('sidebar-main-resized');
			}

			$window
				.resize(resize)
				.trigger('resize');

                $('#search-dropdown').on('keyup change', function() {
				let search 	= $(this).val(),
					dom		= $('#search-dropdown-results');

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

		});
	</script>

</head>

<body>

    @include('admin.layouts.navbar')

    <!-- Page content -->
	<div class="page-content">

        @include('admin.layouts.sidebar')

        <!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				@include('admin.layouts.header')

				@yield('content')

				@include('admin.layouts.footer')

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    @yield('modal')

</body>
</html>
