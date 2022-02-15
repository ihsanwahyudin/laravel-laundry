<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title')</title>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/iconly/bold.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/css/app.css') }}">
	<link rel="shortcut icon" href="{{ asset('vendors/mazer/dist/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/mazer/dist/assets/vendors/fontawesome/all.min.css') }}">
    @stack('css')
</head>
<body>

    <div id="app">
        @include('layout.sidebar')
        <div id="main">
            @yield('main')
            @include('layout.footer')
        </div>
    </div>

    <script src="{{ asset('vendors/mazer/dist/assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/fontawesome/all.min.js') }}"></script>
	<script src="{{ asset('vendors/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script src="{{ asset('vendors/mazer/dist/assets/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('vendors/mazer/dist/assets/js/mazer.js') }}"></script>
    <script src="{{ asset('vendors/mazer/dist/assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendors/axios/axios.min.js') }}"></script>
    @stack('script')
</body>

</html>
