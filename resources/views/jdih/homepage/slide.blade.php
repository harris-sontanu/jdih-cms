<div class="profile-cover position-relative">

    <div id="carouselExampleFade" class="carousel slide carousel-fade overlay" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url({{ asset('assets/jdih/images/demo/slide2.jpg') }}); background-position:bottom; min-height: 480px"></div>
            <div class="carousel-item" style="background-image: url({{ asset('assets/jdih/images/demo/slide1.jpg') }}); background-position:center; min-height: 480px"></div>
            <div class="carousel-item" style="background-image: url({{ asset('assets/jdih/images/demo/slide3.jpg') }}); background-position:center; min-height: 480px"></div>
            <div class="carousel-item" style="background-image: url({{ asset('assets/jdih/images/demo/slide4.jpg') }}); background-position:center; min-height: 480px"></div>
        </div>
    </div>

    <div class="container" style="margin-top: -480px; height: 480px; z-index: 2; position: relative;">
        <div class="content-wrapper">
            <div class="content">
                <div class="row gx-7">
                    <div class="col-xl-6 m-auto">
                        <h2 class="fw-bold mt-5 text-white display-6">
                            Cari Produk Hukum <br />
                            <span id="first-typer" class="typer fw-bold text-nowrap text-danger display-6" data-delay="100" data-words="peraturan,monografi hukum,artikel hukum,putusan pengadilan">peraturan</span>
                            <span class="cursor fw-bold text-danger display-6" data-owner="first-typer"></span>
                        </h2>
                        <h3 class="text-white">{{ $appDesc }}</h3>
                        <div class="d-flex">

                            <button type="button" class="btn btn-danger btn-lg fw-bold px-3" data-bs-toggle="modal" data-bs-target="#search-modal">Cari Produk Hukum<i class="ph-magnifying-glass ms-2"></i></button>
                            <a href="{{ route('legislation.index') }}" class="btn btn-lg btn-outline-danger px-3 fw-bold ms-3">Telusuri<i class="ph-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-6 text-center">
                        <div class="row mt-5">
                            <div class="col">
                                <img src="{{ asset('assets/jdih/images/backgrounds/baliprov.png') }}" class="img-fluid" height="94">
                            </div>
                            <div class="col">
                                <img src="{{ asset('assets/jdih/images/backgrounds/gubwagub.png') }}" class="img-fluid" height="94">
                            </div>
                        </div>
                        <img src="{{ asset('assets/jdih/images/backgrounds/nangunsatkerthi2.png') }}" class="img-fluid mt-3 mb-4 px-5">
                        <h3 class="fw-bold text-white"><?php echo $company;?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
