<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Laundry Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/pages/auth.css') }}" />
</head>

<body>
    <div id="auth">

<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                {{-- <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a> --}}
            </div>
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle mb-5">Please fill new password for your email.</p>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" value="{{ $email }}" readonly>
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                        <div class="position-absolute invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="New Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                        <div class="position-absolute invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" name="password_confirmation" class="form-control form-control-xl" placeholder="Confirm Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Reset Password</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Remember your account? <a href="/login" class="font-bold">Log in</a>.
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>
</body>

</html>
