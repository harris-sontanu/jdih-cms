<!-- Footer -->
<div class="navbar navbar-sm navbar-footer border-top">
    <div class="container-fluid">
        <span>&copy;
            @if (now()->year === 2022)
                2022
            @else
                2022 - {{ now()->year }}
            @endif
            <a href="{{ $appUrl }}">{!! $appName !!}</a> oleh <a href="{{ $companyUrl }}" target="_blank">{{ $company }}</a>
        </span>

        <ul class="nav">
            <li class="nav-item">{{ config('app.version') }}</li>
        </ul>
    </div>
</div>
<!-- /footer -->
