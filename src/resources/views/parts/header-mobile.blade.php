<!-- HEADER -->
<header>
    <div class="logo">
        <a href="{{ route('home') }}"><img src="{{ URL::to('assets/img/icon/Header-Logo.svg') }}" alt="Header-Logo"></a>
        <span>Cooks Delight</span>
    </div>
    <nav id="main-nav">
        <a href="{{ route('home') }}">HOME</a>
        <a href="{{ route('palettes') }}">PALETTES</a>
        <a href="{{ route('recipes') }}">RECIPES</a>
        <a href="{{ route('aboutUs') }}">ABOUT US</a>
    </nav>
    <a href="{{ route('subscribe') }}" class="fullBackButton">SUBSCRIBE</a>
    <div id="burger-menu">
        <div class="burger-line"></div>
        <div class="burger-line"></div>
        <div class="burger-line"></div>
    </div>
</header> <!-- END HEADER -->

<!-- MOBILE NAV -->
<nav id="mobile-nav">

    <a href="{{ route('home') }}">HOME</a>
    <a href="{{ route('palettes') }}">PALETTES</a>
    <a href="{{ route('recipes') }}">RECIPES</a>
    <a href="{{ route('aboutUs') }}">ABOUT US</a>

</nav> <!-- END MOBILE NAV -->