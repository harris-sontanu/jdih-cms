@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

                <!-- Form -->
                <form id="post-form" method="POST" action="{{ route('admin.user.update', $user->id) }}" novalidate enctype="multipart/form-data">
                    @method('PUT')
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
                                                <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="avatar">Foto:</label>
                                            <div class="col-lg-9">
                                                <div class="d-flex mt-0">
                                                    <div class="me-3">
                                                        <img id="avatar-img" src="{{ $user->userPictureUrl($user->picture, $user->name) }}" class="rounded-pill img-fluid" alt="{{ $user->name }}" width="60" height="60">
                                                    </div>

                                                    <div class="flex-fill">
                                                        <div class="custom-file">
                                                            <input type="file" class="form-control @error('picture') is-invalid @enderror" name="picture">
                                                            <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.
                                                            @if ($user->picture)
                                                                <a href="{{ route('admin.user.delete-avatar', $user->id) }}" class="remove-avatar" role="button" data-id="{{ $user->id }}">Hapus foto?</a>
                                                            @endif</div>
                                                            @error('picture')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="phone">Telepon:</label>
                                            <div class="col-lg-9">
                                                <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="www">Website:</label>
                                            <div class="col-lg-9">
                                                <input id="www" type="url" name="www" class="form-control @error('www') is-invalid @enderror" value="{{ $user->www }}" required>
                                                @error('www')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="bio">Biografi:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="bio" id="bio" cols="30" rows="4" placeholder="Ceritakan tentang diri Anda.">{{ $user->bio }}</textarea>
                                                @error('bio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-user-gear me-2"></i>Akun</legend>
                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="username">Nama Akun:</label>
                                            <div class="col-lg-9">
                                                <input id="username" type="email" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Nama Akun" value="{{ $user->username }}" required>
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="email">Email:</label>
                                            <div class="col-lg-9">
                                                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ $user->email }}" required>
                                                <div class="form-text text-muted">Jika Anda mengubah email, sistem akan mengirimkan konfirmasi ke alamat email yang baru. <strong>Alamat email yang baru tidak akan aktif sebelum dikonfirmasi.</strong></div>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="email">Kata Sandi:</label>
                                            <div class="col-lg-9">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#new-password-modal" class="btn btn-outline-warning new-password">Ubah Kata Sandi</button>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label">Level</label>
                                            <div class="col-lg-9">
                                                <select name="role" class="select @error('role') is-invalid @enderror">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->value }}" @selected($user->role == $role)>{{ $role->label() }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-sparkle me-2"></i>Akun Media Sosial</legend>
                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="facebook">Facebook:</label>
                                            <div class="col-lg-9">
                                                <input id="facebook" type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ $user->facebook }}" required>
                                                @error('facebook')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="twitter">Twitter:</label>
                                            <div class="col-lg-9">
                                                <input id="twitter" type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ $user->twitter }}" required>
                                                @error('twitter')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="instagram">Instagram:</label>
                                            <div class="col-lg-9">
                                                <input id="instagram" type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ $user->instagram }}" required>
                                                @error('instagram')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="tiktok">TikTok:</label>
                                            <div class="col-lg-9">
                                                <input id="tiktok" type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ $user->tiktok }}" required>
                                                @error('tiktok')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="youtube">YouTube:</label>
                                            <div class="col-lg-9">
                                                <input id="youtube" type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ $user->youtube }}" required>
                                                @error('youtube')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
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
            <!-- /left content -->

            <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                <div class="sidebar-content">
                    @include('admin.user.show')
                </div>
                <!-- /sidebar content -->

            </div>
            <!-- /right sidebar component -->

        </div>
        <!-- /inner container -->

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.user.new_password')
@endsection

@section('script')
    @include('admin.user.script')
@endsection
