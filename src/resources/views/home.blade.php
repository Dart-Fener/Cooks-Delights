@extends('layouts.theme')

@section('title','Cooks Delights - Home')

@section('content')

    <!-- HERO -->
    <section id="hero">

        <h1>UNLEASH CULINARY EXCELLENCE</h1>
        <h3>Explore a world of flavors, discover handcrafted recipes, and let the aroma of our passion for cooking fill your kitchen</h3>
        <button class="fullBack">EXPLORE RECIPES</button>

    </section> <!-- END HERO -->

    <!-- PALETTE HOME -->
    <section id="palette-home">

        <button class="fullBack">EXPLORE</button>
        <h2>DISCOVER OUR DIVERSE PALETTES</h2>
        <p>If you are a breakfast enthusiast, a connoisseur of savory delights, or on the lookout for irresistible desserts, our curated selection has something to satisfy every palate.</p>
        <a href="{{ route('palettes') }}" class="fullBackButton">SEE MORE</a>

    </section> <!-- END PALETTE HOME -->

    @if(count($randomCards))
        <!-- FEATURED RECIPES -->
        <section id="featured-recipes">
            <div id="featured-recipes-title-arrows">
                <h2>FEATURED RECIPES</h2>
                <div id="arrows">
                    <img id="arrow-left" src="assets/img/icon/Arrow-Left.svg" alt="Arrow-Left-Icon">
                    <img id="arrow-right" src="assets/img/icon/Arrow-Right.svg" alt="Arrow-Right-Icon">
                </div>
            </div>
            
            <!-- SLICK CAROUSEL APPLIED -->
            <div id="featured-carousel-slider">
                @foreach ($randomCards as $card)
                    <div class='recipes-cards-slider'>
                        <img class='cardSliderImg' src='{{ $card->thumb }}' alt='{{ $card->recipe }}-Img'>
                        <img class='paletteSliderIcon' src='assets/img/icon/category/{{ $card->category }}.svg' alt='{{ $card->category }}-Icon'>
                        <div class='inner-card-slider'>
                            <h5>{{ $card->recipe }}</h5>
                            <h6>Category:<span>{{ $card->category }}</span></h6>
                            <h6>Nationality:<span>{{ $card->area }}</span></h6>
                            @if($card->tags)
                                <h6>Tags: <span>{{ $card->tags }}</span></h6>
                            @endif
                        </div>
                        <a href='{{ route('recipe-detailes', ['slug' => $card->slug] ) }}' class='emptyBackButton' target='_blank'>VIEW RECIPE</a>                                    
                    </div>
                @endforeach
            </div>

        </section> <!-- END FEATURED RECIPES -->
    @endif

    <!-- ABOUT US HOME -->
    <section id="about-us-home">
        <div id="about-us-home-title">
            <button class="fullBack">ABOUT US</button>
            <h2>OUR CULINARY CHRONICLE</h2>
            <p>Our journey is crafted with dedication, creativity, and an unrelenting commitment to delivering delightful culinary experiences. Join us in savoring the essence of every dish and the stories that unfold.</p>
            <a href="{{ route('aboutUs') }}" class="emptyBackButton">READ MORE</a>
        </div>
        <div class="about-us-home-media"></div>
        <div class="about-us-home-media"></div>
        <div class="about-us-home-media">
            <video controls autoplay loop>
                <source src="assets/video/About-Us-3.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section> <!-- END ABOUT US HOME -->
    
    <!-- SUBSCRIBE -->
    <section id="home-subscribe">
        <button class="emptyBack">SUBSCRIBE</button>
        <h2>JOIN THE FUN SUBSCRIBE NOW!</h2>
        <p>Subscribe to our newsletter for a weekly serving of recipes, cooking tips, and exclusive insights straight to your inbox.</p>
        <a href="{{ route('subscribe') }}" class="fullBackButton">SUBSCRIBE</a>
    </section> <!-- END SUBSCRIBE -->

@endsection