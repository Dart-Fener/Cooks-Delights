@extends('layouts.theme')

@section('title','Cooks Delights - Palettes')

@section('content')

    <!-- PAGE TITLE -->
    <div class="page-title">

        <h3>Palettes</h3>
        <nav class="page-title-nav">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>Palettes</span>
        </nav>

    </div> <!-- END PAGE TITLE -->

    <!-- PALETTE -->
    <section id="palette">

        <div id="palette-title">
            <button class="fullBack">EXPLORE</button>
            <h2>OUR DIVERSE PALETTES</h2>
            <p>If you are a breakfast enthusiast, a connoisseur of savory delights, or on the lookout for irresistible desserts, our curated selection has something to satisfy every palate.</p>
        </div>
        @if(count($categories) || count($areas) || count($tags))
            <button class="emptyBack">PALETTE CATEGORY</button>
            <div id="palette-list-categories">
                @foreach ($categories as $category)
                    <div class="palette-categories">
                        <img src="assets/img/icon/category/{{ $category->name }}.svg" alt="{{ $category->name }}-Icon">
                        <span>{{ $category->name }}</span>
                    </div>
                @endforeach
            </div>
            <button class="emptyBack">PALETTE NATIONALITY</button>
            <div class="palette-list-flags-tags">
                @foreach($areas as $area)
                    <span>{{ $area->name }}</span>
                @endforeach
            </div>
            <button class="emptyBack">PALETTE TAG</button>
            <div class="palette-list-flags-tags">
                @foreach ($tags as $tag)
                    <span>{{ $tag->name }}</span> 
                @endforeach
            </div>
        @else
            <div id="palettes-list-categories">
                <button class="emptyBack" id="palettes-empty">NOT AVAILABLE RECIPES PALETTES</button>
            </div>
        @endif

    </section> <!-- END PALETTE -->

@endsection
    