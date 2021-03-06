<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Laundry Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/bootstrap.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('vendors/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/pages/auth.css') }}" />
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="/"><strong>
                                <h1>My Laundry</h1>
                            </strong></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <form action="/authenticate" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username"
                                class="form-control form-control-xl @error('username') is-invalid @enderror"
                                placeholder="Username" value="{{ old('username') }}" autocomplete="off"
                                autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('username')
                                <span class="position-absolute invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                placeholder="Password" />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="position-absolute invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- @error('email')
                                <div class="mt-2">
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror --}}
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" name="remember" value="true"
                                id="flexCheckDefault" />
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        {{-- <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Sign up</a>.</p> --}}
                        <p><a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    {{-- <img class="w-100 h-100" src="{{ asset('images/bg-laundry.jpg') }}" style="object-fit: cover"> --}}
                    {{-- <img src="{{ asset('images/bg-laundry.jpg') }}" class="img-fluid" alt="..."> --}}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
