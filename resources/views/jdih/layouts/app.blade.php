<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-static">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', strip_tags($appName))</title>

	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/admin/favicon/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/admin/favicon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/admin/favicon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('assets/admin/favicon/site.webmanifest') }}">

	<!-- Global stylesheets -->
	<link href="{{ asset('assets/jdih/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/jdih/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/jdih/css/ltr/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/jdih/css/style.css') }}" rel="stylesheet" type="text/css">
    @isset ($styles)
        @foreach ($styles as $style)
            <link href="{{ asset($style) }}" rel="stylesheet" type="text/css">
        @endforeach
    @endisset
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('assets/jdih/demo/demo_configurator.js') }}"></script>
	<script src="{{ asset('assets/jdih/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/jdih/js/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/jdih/js/vendor/ui/fab.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	@isset($vendors)
        @foreach ($vendors as $vendor)
            <script src="{{ asset($vendor) }}"></script>
        @endforeach
    @endisset

	<script src="{{ asset('assets/jdih/js/app.js') }}"></script>
	<script async src="https://unpkg.com/typer-dot-js@0.1.0/typer.js"></script>
    <script src="{{ asset('assets/jdih/js/pdfThumbnails.js') }}" data-pdfjs-src="{{ asset('assets/jdih/js/vendor/pdf.js/build/pdf.js') }}"></script>
    <script>
        $(function() {
            $('#search-dropdown').on('keyup change', function() {
                let search 	= $(this).val(),
                    dom		= $('#search-dropdown-results');

                    console.log(search);

                if (search.length > 0) {
                    $(this).dropdown('show');

                    $.get('/legislation/search', {search: search})
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

    @yield('script')
	<!-- /theme JS files -->

</head>

<body>

    @include('jdih.layouts.topbar')

    @include('jdih.layouts.header')

    @include('jdih.layouts.navbar')

	@yield('content')

    @include('jdih.layouts.footer')

</body>
</html>
