<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg">
    <div class="container jusitfy-content-start px-lg-3">
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
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded" title="Mode terang">
                    <i class="ph-sun"></i>
                    <span class="d-xl-none ms-2">Mode terang</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link rounded dropdown-toggle" data-bs-toggle="dropdown" title="Pilih Bahasa">
                    <img src="{{ asset('assets/jdih/images/lang/id.svg') }}" class="h-16px me-2" alt="Indonesian">
                    Indonesian
                </a>

                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item active">
                        <img src="{{ asset('assets/jdih/images/lang/id.svg') }}" class="h-16px me-2" alt="Indonesian">
                        Indonesian
                    </a>
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/jdih/images/lang/gb.svg') }}" class="h-16px me-2" alt="">
                        English
                    </a>
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/jdih/images/lang/cn.svg') }}" class="h-16px me-2" alt="">
                        Mandarin
                    </a>
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/jdih/images/lang/jp.svg') }}" class="h-16px me-2" alt="">
                        Japanese
                    </a>
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('assets/jdih/images/lang/sa.svg') }}" class="h-16px me-2" alt="">
                        Arabic
                    </a>
                </div>
            </li>
        </ul>

        <button type="button" class="btn btn-outline-yellow btn-icon order-3 ms-lg-2">
            <i class="ph-sign-in ms-lg-1"></i>
            <span class="d-none d-lg-inline-block ms-2 me-1">Masuk</span>
        </button>
    </div>
</div>
<!-- /main navbar -->
