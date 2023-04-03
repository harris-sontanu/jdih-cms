<!-- Main navbar -->
<div class="navbar navbar-sm navbar-dark navbar-static navbar-expand-lg py-1">
    <div class="container jusitfy-content-start px-lg-3">

        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="index.html" class="d-inline-flex align-items-center">
                <img src="{{ $appLogoUrl }}" alt="{{ $appName }}">
            </a>
        </div>

        <div class="nav order-2 order-lg-1 ms-2 ms-lg-3 me-lg-auto">
            <span class="navbar-text d-block d-xl-inline-block">
                <i class="ph-bank me-1"></i>
                {{ $company }}
            </span>
            <span class="navbar-text d-block d-xl-inline-block ms-3">
                <i class="ph-envelope me-1"></i>
                {{ $email }}
            </span>
            <span class="navbar-text d-block d-xl-inline-block ms-3">
                <i class="ph-phone me-1"></i>
                {{ $phone }}
            </span>
        </div>

        <ul class="navbar-nav ms-lg-2 order-1 order-lg-2 ">
            <li class="nav-item">
                <label class="navbar-nav-link navbar-nav-link-icon rounded cursor-pointer" for="theme-switch" title="Aktifkan mode gelap">
                    <input type="checkbox" class="btn-check" id="theme-switch" autocomplete="off">
                    <i class="ph-moon"></i>
                </label>
            </li>
        </ul>

    </div>
</div>
<!-- /main navbar -->
