@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('admin.setting.update') }}" novalidate enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-strategy me-2"></i>Aplikasi</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Nama:</label>
                                    <div class="col-lg-9">
                                        <input id="appName" type="text" name="appName" class="form-control @error('appName') is-invalid @enderror" value="{{ $settings['appName'] }}">
                                        @error('appName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Keterangan:</label>
                                    <div class="col-lg-9">
                                        <textarea id="appDesc" type="text" name="appDesc" rows="4" spellcheck="false" class="form-control @error('appDesc') is-invalid @enderror">{{ $settings['appDesc'] }}</textarea>
                                        @error('appDesc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Website:</label>
                                    <div class="col-lg-9">
                                        <input id="appUrl" type="url" name="appUrl" class="form-control @error('appUrl') is-invalid @enderror" value="{{ $settings['appUrl'] }}">
                                        @error('appUrl')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Logo:</label>
                                    <div class="col-lg-9">
                                        <div class="d-flex mt-0">
                                            <div class="me-3">
                                                <img id="avatar-img" src="{{ $settings['appLogoUrl'] }}" class="rounded-pill img-fluid" alt="Logo" width="60" height="60">
                                            </div>

                                            <div class="flex-fill">
                                                <div class="custom-file">
                                                    <input id="appLogo" type="file" name="appLogo" class="form-control @error('appLogo') is-invalid @enderror" value="{{ $settings['appLogo'] }}">
                                                    <span class="form-text text-muted">Format: .jpg, .jpeg, .png, .gif, .bmp, .svg, .webp. Ukuran maks: 2Mb.</span>
                                                    @error('appLogo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Kode Wilayah:</label>
                                    <div class="col-lg-9">
                                        <input id="region_code" type="number" name="region_code" class="form-control @error('region_code') is-invalid @enderror" value="{{ $settings['region_code'] }}">
                                        <span class="form-text text-muted">Kode wilayah dapat dilihat pada <a href="https://jdih.baliprov.go.id/produk-hukum/peraturan-perundang-undangan/permenkumham/24804">Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 8 Tahun 2019 tentang Standar Pengelolaan Dokumen dan Informasi Hukum</a>.</span>
                                        @error('region_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-buildings me-2"></i>Instansi</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Nama:</label>
                                    <div class="col-lg-9">
                                        <input id="company" type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ $settings['company'] }}">
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Website:</label>
                                    <div class="col-lg-9">
                                        <input id="companyUrl" type="url" name="companyUrl" class="form-control @error('companyUrl') is-invalid @enderror" value="{{ $settings['companyUrl'] }}">
                                        @error('companyUrl')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-9">
                                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $settings['email'] }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Alamat:</label>
                                    <div class="col-lg-9">
                                        <input id="address" type="text" name="address" placeholder="Alamat" class="form-control mb-3 @error('address') is-invalid @enderror" value="{{ $settings['address'] }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input type="text" name="city" placeholder="Desa/Kelurahan" class="form-control @error('city') is-invalid @enderror" value="{{ $settings['city'] }}">
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input type="text" name="district" placeholder="Kecamatan" class="form-control @error('district') is-invalid @enderror" value="{{ $settings['district'] }}">
                                                @error('district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" name="regency" placeholder="Kabupaten" class="form-control @error('regency') is-invalid @enderror" value="{{ $settings['regency'] }}">
                                                @error('regency')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input type="text" name="province" placeholder="Provinsi" class="form-control @error('province') is-invalid @enderror" value="{{ $settings['province'] }}">
                                                @error('province')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Kode Pos:</label>
                                    <div class="col-lg-9">
                                        <input id="zip" type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ $settings['zip'] }}">
                                        @error('zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Telepon:</label>
                                    <div class="col-lg-9">
                                        <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $settings['phone'] }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Fax</label>
                                    <div class="col-lg-9">
                                        <input id="fax" type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{ $settings['fax'] }}">
                                        @error('fax')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-sparkle me-2"></i>Media Sosial</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Facebook</label>
                                    <div class="col-lg-9">
                                        <input id="facebook" type="text" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ $settings['facebook'] }}">
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Twitter</label>
                                    <div class="col-lg-9">
                                        <input id="twitter" type="text" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ $settings['twitter'] }}">
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">Instagram</label>
                                    <div class="col-lg-9">
                                        <input id="instagram" type="text" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ $settings['instagram'] }}">
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">TikTok</label>
                                    <div class="col-lg-9">
                                        <input id="tiktok" type="text" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ $settings['tiktok'] }}">
                                        @error('tiktok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label">YouTube</label>
                                    <div class="col-lg-9">
                                        <input id="youtube" type="text" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ $settings['youtube'] }}">
                                        @error('youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </fieldset>

                            <div class="mb-3 row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="submit" class="btn btn-indigo">Ubah</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
    <!-- /content area -->

@endsection
