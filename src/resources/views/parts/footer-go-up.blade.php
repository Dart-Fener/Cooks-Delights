<!-- FOOTER -->
<footer>
    <div id="footer-row">
        <div class="logo">
            <a href="{{ route('home') }}"><img src="{{ URL::to('assets/img/icon/Footer-Logo.svg') }}" alt="Footer-Logo"></a>
            <span>Cooks Delight</span>
        </div>
        <nav>
            <a href="{{ route('home') }}">HOME</a>
            <a href="{{ route('palettes') }}">PALETTES</a>
            <a href="{{ route('recipes') }}">RECIPES</a>
            <a href="{{ route('aboutUs') }}">ABOUT US</a>
        </nav>
        <div id="socials-link">
            <img src="{{ URL::to('assets/img/icon/Tik-Tok.svg') }}" alt="Tik-Tok-Icon">
            <img src="{{ URL::to('assets/img/icon/Facebook.svg') }}" alt="Facebook-Icon">
            <img src="{{ URL::to('assets/img/icon/Instagram.svg') }}" alt="Instagram-Icon">
            <img src="{{ URL::to('assets/img/icon/Youtube.svg') }}" alt="Youtube-Icon">
        </div>
    </div>
    <h6>COPYRIGHT: © 2025 COOKS DELIGHT</h6>
</footer> <!-- END FOOTER -->

<!-- GO UP ARROW -->
<div id="go-up-arrow">
    <img src="{{ URL::to('assets/img/icon/Arrow-Top.svg') }}" alt="Arrow-Top-Icon">
</div>