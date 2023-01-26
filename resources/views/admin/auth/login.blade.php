@extends('admin.layouts.auth.app')

@section('content')
    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login card -->
                    <form class="login-form" method="POST" action="{{ route('admin.login') }}" novalidate>
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mt-2 mb-3">
                                        <img src="{{ $appLogoUrl }}" class="h-48px" alt="{{ $appName }}">
									</div>
                                    <h1 class="fw-bold font-title text-indigo"><span class="text-pink">JDIH</span> Admin</h1>
                                    {{-- <span class="d-block px-4">{!! $appDesc !!}</span> --}}
                                </div>

                                <div class="mb-3">
									<label class="form-label">Nama Akun atau Email</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>
										<div class="form-control-feedback-icon">
											<i class="ph-user-circle text-muted"></i>
										</div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label">Kata Sandi</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password">
										<div class="form-control-feedback-icon">
											<i class="ph-lock text-muted"></i>
										</div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
									</div>
								</div>

                                <div class="d-flex align-items-center mb-3">
									<label class="form-check">
										<input id="remember_me" type="checkbox" name="remember" class="form-check-input">
										<span class="form-check-label">Ingat saya</span>
									</label>

                                    @if (Route::has('password.request'))
									    <a href="{{ route('password.request') }}" class="ms-auto link-indigo">Lupa kata sandi?</a>
                                    @endif
								</div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-indigo w-100">Masuk<i class="ph-sign-in ps-2"></i></button>
                                </div>

                                <span class="d-block text-center text-muted">
                                    <span class="d-block">
                                        © Hak cipta
                                        @if (now()->year === 2022)
                                            2022
                                        @else
                                            2022 - {{ now()->year }}
                                        @endif
                                        <a class="link-indigo" href="{{ $companyUrl }}" target="_blank">{{ $company }}</a>
                                    </span>
                                    <span class="text-muted">{{ $appName }} v5.0.1</span>
                                </span>
                            </div>
                        </div>
                    </form>
                    <!-- /login card -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

@endsection
