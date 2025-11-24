<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FAVICONS -->
    <link href="{{ URL::to('assets/img/icon/Header-Logo.svg') }}" rel="icon">

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">

    <title>@yield('title','Cooks Delights')</title>
</head>

<body>

    <!-- PARTS HEADER AND MOBILE NAV -->
    @include('parts.header-mobile')

    <!-- If the yield title is equal to Cooks Delights - Home (Home Page) than add to the tag the id=home -->
    <div class="container" {{ $__env->yieldContent('title') == 'Cooks Delights - Home' ? 'id=home' : null }}>
        @yield('content')
    </div>

    <!-- PARTS FOOTER AND ARROW UP -->
    @include('parts.footer-go-up')

    <!-- JAVASCRIPT -->
    <script type="module" src="{{ asset('assets/script.js') }}"></script>
    
</body>
</html>