<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="/admin" class="d-inline-flex align-items-center">
                <img src="{{ $appLogoUrl }}" alt="{{ $appName }}">
                <h3 class="fw-bold m-0 ps-2 d-none d-sm-block font-title">
                    <span class="text-pink">JDIH</span> Admin
                </h3>
            </a>
        </div>

        <ul class="nav flex-row">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>

            <li class="nav-item">
                <label class="navbar-nav-link navbar-nav-link-icon rounded-pill cursor-pointer" for="btncheck1" title="Aktifkan mode gelap">
                    <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                    <i class="ph-moon"></i>
                </label>
            </li>

        </ul>

        <div class="navbar-collapse justify-content-center flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            <div class="navbar-search flex-fill position-relative mt-2 mt-lg-0 mx-lg-3">
                <div class="form-control-feedback form-control-feedback-start flex-grow-1" data-color-theme="dark">
                    <input id="search-dropdown" type="text" class="form-control bg-transparent rounded-pill" name="search" autocomplete="off" placeholder="Cari Produk Hukum">
                    <div class="form-control-feedback-icon">
                        <i class="ph-magnifying-glass"></i>
                    </div>
                    <div id="search-dropdown-results" class="dropdown-menu w-100" data-color-theme="light"></div>
                </div>
            </div>
        </div>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="{{ Auth::guard('admin')->user()->userPictureUrl(Auth::guard('admin')->user()->picture, Auth::guard('admin')->user()->name) }}" class="w-32px h-32px rounded-pill" alt="{{ Auth::guard('admin')->user()->name }}">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::guard('admin')->user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('admin.user.edit', Auth::guard('admin')->user()->id) }}" class="dropdown-item">
                        <i class="ph-user-gear me-2"></i>
                        Profilku
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item"><i class="ph-sign-out me-2"></i>{{ __('Keluar') }}</a>
                    </form>
                </div>
            </li>
        </ul>

    </div>
</div>
<!-- /main navbar -->
