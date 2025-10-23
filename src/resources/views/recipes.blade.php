@extends('layouts.theme')

@section('content')
   
    <!-- PAGE TITLE -->
    <div class="page-title">
        <h3>Recipes</h3>
        <nav class="page-title-nav">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <h4>Recipes</h4>
        </nav>
    </div> <!-- END PAGE TITLE -->

    <!-- RECIPES -->
    <section id="recipes">
        <div id="recipes-title">
            <button class="fullBack">RECIPES</button>
            <h2>EMBARK ON A JOURNEY</h2>
            <p>With our diverse collection of recipes we have something to satisfy every palate.</p>
        </div>
        @if(count($categories) || count($areas) || count($tags))
            <div id="recipes-selectors-search">
                <fieldset id="selectors">
                    <h2>SELECT RECIPE BY PALETTES</h2>
                    <form id="selectors-form">
                        @csrf
                        <select name="selCat" class="selection" id="selCat">
                            <option value="0">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        
                        <select name="selArea" class="selection" id="selArea">
                            <option value="0">Select Nationality</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        
                        <select name="selTag" class="selection" id="selTag">
                            <option value="0">Select Tag</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </fieldset>
                <fieldset id="ingredient">
                    <h2>SEARCH RECIPE BY INGREDIENT</h2>
                    <form id="form-search">
                        @csrf
                        <input type="text" name="search" id="search" minlength="1" autocomplete="off" required>
                    </form>
                    <form id="remove">
                        @csrf
                        <input type="submit" value="Remove Ingredient">
                    </form>           
                </fieldset>
            </div>
        @else
            <div id="recipes-selectors-search-empty">
                <button class="emptyBack" id="recipes-empty">NOT AVAILABLE RECIPES</button>
            </div>
        @endif
        
        <!-- KEY FRAMES LOADER -->
        <div id="loading"></div>

        <!-- CARDS LIST -->
        <div id="recipes-cards">
            <div id="recipes-cards-title">
                <h1></h1>
            </div>
            <div id="recipes-cards-list"></div>
        </div>
    </section> <!-- END RECIPES -->

@endsection