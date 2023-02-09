<!-- Footer -->
<section class="bg-dark text-light">
    <div class="container">
        <div class="content-wrapper">
            <div class="content py-5">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <img src="{{ $appLogoUrl }}" alt="{{ $appName }}" class="me-3" height="58">
                            <h4 class="fw-bold">{!! $appName !!}</h4>
                        </div>
                        <p class="fs-lg">JDIH Pemerintah Provinsi Bali hadir untuk meningkatkan pelayanan kepada masyarakat atas kebutuhan dokumentasi dan informasi hukum secara lengkap, akurat, mudah dan cepat.</p>
                    </div>
                    <div class="col-lg-2">
                        <h4 class="fw-bold">Navigasi</h4>
                    </div>
                    <div class="col-lg-4">
                        <h4 class="fw-bold">Kontak Kami</h4>
                    </div>
                    <div class="col-lg-3">
                        <h4 class="fw-bold">Statistik Pengunjung</h4>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-0">
    </div>
</section>
<div class="navbar navbar-sm navbar-dark navbar-footer">
    <div class="container px-lg-3">
        <span class="navbar-text d-block d-xl-inline-block">&copy; {{ now()->year }} <a href="{{ $appUrl }}">{{ strip_tags($appName) }}</a> oleh <a href="{{ $companyUrl }}" target="_blank">{{ $company }}</a></span>
        <ul class="navbar-nav ms-xl-auto">
            <li class="nav-item"><a href="kebijakan/syarat-dan-ketentuan" class="navbar-nav-link rounded">Syarat dan Ketentuan</a></li>
            <li class="nav-item"><a href="kebijakan/privasi" class="navbar-nav-link rounded">Privasi</a></li>
        </ul>
    </div>
</div>
<!-- /footer -->
