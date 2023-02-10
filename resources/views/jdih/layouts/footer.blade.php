<!-- Footer -->
<section class="bg-dark text-light">
    <div class="container" style="background-image: url({{ asset('assets/jdih/images/backgrounds/indonesia-map.png') }}); background-position:center; background-repeat: no-repeat">
        <div class="content-wrapper">
            <div class="content py-5">
                <div class="row gx-5">
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <img src="{{ $appLogoUrl }}" alt="{{ $appName }}" class="me-3" height="58">
                            <h4 class="fw-bold">{!! $appName !!}</h4>
                        </div>
                        <p class="fs-lg">JDIH Pemerintah Provinsi Bali hadir untuk meningkatkan pelayanan kepada masyarakat atas kebutuhan dokumentasi dan informasi hukum secara lengkap, akurat, mudah dan cepat.</p>
                    </div>
                    <div class="col-lg-2">
                        <h4 class="fw-bold">Navigasi</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-light">Beranda</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Produk Hukum</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Berita</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Profil</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Galeri</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Kontak</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h4 class="fw-bold">Kontak Kami</h4>
                        <dl class="row mb-0">
                            <dt class="col-sm-1"><i class="ph-phone"></i></dt> 
                            <dd class="col-sm-11 mb-2">{{ $phone }}</dd> 
                            
                            <dt class="col-sm-1"><i class="ph-house"></i></dt> 
                            <dd class="col-sm-11 mb-2">
								{{ $fullAddress }}						
                            </dd>  
                            
                            <dt class="col-sm-1"><i class="ph-envelope"></i></dt> 
                            <dd class="col-sm-11 mb-2">{{ $email }}</dd>  

                            <dt class="col-sm-1"><i class="ph-globe"></i></dt> 
                            <dd class="col-sm-11 mb-2">{{ $appUrl }}</dd>  
                            
						</dl>
                        <hr>
                        <ul class="list-inline list-inline-condensed">
                            @isset($facebook)                                
                                <li class="list-inline-item">
                                    <a href="{{ $facebook }}" class="text-light" title="Facebook"><i class="ph-facebook-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset
                            
                            @isset($twitter)       
                                <li class="list-inline-item">
                                    <a href="{{ $twitter }}" class="text-light" title="Twitter"><i class="ph-twitter-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($instagram)       
                                <li class="list-inline-item">
                                    <a href="{{ $instagram }}" class="text-light" title="Instagram"><i class="ph-instagram-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($tiktok)       
                                <li class="list-inline-item">
                                    <a href="{{ $tiktok }}" class="text-light" title="TikTok"><i class="ph-tiktok-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($youtube)       
                                <li class="list-inline-item">
                                    <a href="{{ $youtube }}" class="text-light" title="YouTube"><i class="ph-youtube-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <h4 class="fw-bold">Statistik Pengunjung</h4>
                        <ul class="list list-unstyled mb-0">
							<li class="d-flex"><span class="me-auto">Hari ini</span><label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">308</label></li>
							<li class="d-flex"><span class="me-auto">Minggu lalu</span><label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">10.325</label></li>
							<li class="d-flex"><span class="me-auto">Bulan lalu</span><label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">43.804</label></li>
							<li class="d-flex"><span class="me-auto">Total</span><label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">1.923.993</label></li>
							<li class="d-flex"><span class="me-auto">Online</span><label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">38</label></li>
						</ul>
                        <hr>
                        <h5 class="fw-bold">Apakah pelayanan dokumentasi di Biro Hukum Setda Provinsi Bali dirasa puas?</h5>
                        <button type="button" class="btn btn-outline-yellow btn-icon">
                            <i class="ph-pencil-line ms-lg-1"></i>
                            <span class="d-none d-lg-inline-block ms-2 me-1">Ikuti Survei IKM</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-0">
    </div>
</section>
<div class="navbar navbar-sm navbar-dark navbar-expand-xl navbar-footer">
    <div class="container px-lg-3">
        <span class="navbar-text d-block d-xl-inline-block">&copy; {{ now()->year }} <a href="{{ $appUrl }}">{{ strip_tags($appName) }}</a> oleh <a href="{{ $companyUrl }}" target="_blank">{{ $company }}</a></span>
        <ul class="navbar-nav ms-xl-auto">
            <li class="nav-item"><a href="kebijakan/syarat-dan-ketentuan" class="navbar-nav-link rounded">Syarat dan Ketentuan</a></li>
            <li class="nav-item"><a href="kebijakan/privasi" class="navbar-nav-link rounded">Privasi</a></li>
        </ul>
    </div>
</div>
<!-- /footer -->
