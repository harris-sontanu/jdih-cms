@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('admin.employee.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-user-list me-2"></i>Profil</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">Nama:</label>
                                    <div class="col-lg-9">
                                        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="avatar">Foto:</label>
                                    <div class="col-lg-9">
                                        <div class="d-flex mt-0">
                                            <div class="me-3">
                                                <img id="avatar-img" src="{{ asset('assets/admin/images/placeholders/user.png') }}" class="rounded-pill" alt="placeholder" width="60" height="60">
                                            </div>

                                            <div class="flex-fill">
                                                <input id="avatar-input" type="file" class="form-control @error('picture') is-invalid @enderror" name="picture">
                                                <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
                                                @error('picture')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="nip">NIP:</label>
                                    <div class="col-lg-9">
                                        <input id="nip" type="number" name="nip" class="form-control" value="{{ old('nip') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="position">Jabatan:</label>
                                    <div class="col-lg-9">
                                        <input id="position" type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="rank">Pangkat:</label>
                                    <div class="col-lg-9">
                                        <input id="rank" type="text" name="rank" class="form-control" value="{{ old('rank') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="groups">Grup:</label>
                                    <div class="col-lg-9">
                                        <select id="groups" name="groups[]" multiple="multiple" class="form-control select @error('groups') is-invalid @enderror">
                                            <option value="">Pilih Grup</option>
                                                @foreach ($groups as $key => $value)
                                                    <option value="{{ $key }}" @selected(old('groups') == $key)>{{ $value }}</option>
                                                @endforeach
                                        </select>
                                        @error('groups')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="bio">Biografi:</label>
                                    <div class="col-lg-9">
                                        <textarea class="form-control" name="bio" id="bio" cols="30" rows="4" placeholder="Ceritakan tentang diri Anda.">{{ old('bio') }}</textarea>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-phone me-2"></i>Kontak</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="email">Email:</label>
                                    <div class="col-lg-9">
                                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="phone">Telepon Seluler:</label>
                                    <div class="col-lg-9">
                                        <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="address">Alamat:</label>
                                    <div class="col-lg-9">
                                        <input id="address" type="text" name="address" placeholder="Jl." class="form-control mb-3" value="{{ old('address') }}">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input id="city" type="text" name="city" placeholder="Desa/Kelurahan" class="form-control" value="{{ old('city') }}">
                                            </div>
                                            <div class="col">
                                                <input id="district" type="text" name="district" placeholder="Kecamatan" class="form-control" value="{{ old('district') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input id="regency" type="text" name="regency" placeholder="Kabupaten/Kota" class="form-control" value="{{ old('regency') }}">
                                            </div>
                                            <div class="col">
                                                <input id="province" type="text" name="province" placeholder="Provinsi" class="form-control" value="{{ old('province') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-sparkle me-2"></i>Akun Media Sosial</legend>
                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="facebook">Facebook:</label>
                                    <div class="col-lg-9">
                                        <input id="facebook" type="url" name="facebook" class="form-control" value="{{ old('facebook') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="twitter">Twitter:</label>
                                    <div class="col-lg-9">
                                        <input id="twitter" type="url" name="twitter" class="form-control" value="{{ old('twitter') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="instagram">Instagram:</label>
                                    <div class="col-lg-9">
                                        <input id="instagram" type="url" name="instagram" class="form-control" value="{{ old('instagram') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="tiktok">TikTok:</label>
                                    <div class="col-lg-9">
                                        <input id="tiktok" type="url" name="tiktok" class="form-control" value="{{ old('tiktok') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="youtube">YouTube:</label>
                                    <div class="col-lg-9">
                                        <input id="youtube" type="url" name="youtube" class="form-control" value="{{ old('youtube') }}">
                                    </div>
                                </div>

                            </fieldset>

                            <div class="mb-3 row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="submit" class="btn btn-indigo">Simpan</button>
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

@section('script')
    @include('admin.employee.script')
@endsection
