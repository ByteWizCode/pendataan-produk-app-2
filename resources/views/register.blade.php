<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
</head>

<body>
    <div id="auth">

        <div class="row justify-content-center h-100">
            <div class="col-xl-6 col-md-8 col-12">
                <div id="auth-left">
                    <h1 class="auth-title">Register.</h1>
                    <p class="auth-subtitle mb-5">Masukkan data Anda untuk melakukan registrasi.</p>

                    @include('layouts.partials.alert')

                    <form action="{{ route('register.action') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="nama" id="nama"
                                class="form-control form-control-xl @error('nama') is-invalid @enderror"
                                placeholder="Nama" value="{{ old('nama') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" id="email"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                placeholder="Email" value="{{ old('email') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <div class="form-control form-control-xl">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk1"
                                        value="L" checked>
                                    <label class="form-check-label" for="jk1">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk2"
                                        value="P">
                                    <label class="form-check-label" for="jk2">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-control-icon">
                                <i class="bi bi-gender-ambiguous"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" id="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror"
                                placeholder="Confirm Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Buat Akun</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Sudah memiliki akun?
                            <a href="{{ route('login') }}" class="font-bold">Login</a>
                            .
                        </p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div> --}}
        </div>

    </div>

    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
</body>

</html>
