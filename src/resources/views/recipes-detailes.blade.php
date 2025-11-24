@extends('layouts.theme')

@foreach ($recipeList as $detail)
    @section('title','Recipe - '.$detail->name)
@endforeach
     
@section('content')

    <!-- PAGE TITLE -->
    <div class="page-title">
        <h3>Recipes Details</h3>
        <nav class="page-title-nav">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <h4>Recipes Details</h4>
        </nav>
    </div><!-- END PAGE TITLE -->

    @if(count($recipeList))
        <!-- RECIPES DETAILES -->
        <section id="recipe-detailes">
            @foreach ($recipeList as $detail)
                <h1>{{ $detail->name }}</h1>
                <span>{{ $detail->category }} - {{ $detail->area }}</span>
                <div id="recipe-detailes-grid">
                    <div id="grid-ingr-meas">
                        <h2>INGREDIENTS</h2>
                        <ul>
                            @foreach (json_decode($detail->list) as $measure => $ingredient)
                                <li>{{ $measure .' '. $ingredient }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <img id="thumb" src="{{ $detail->thumb }}" alt="{{ $detail->name }}-Img">
                </div>
                <div id="recipe-instructions">
                    <h2>INSTRUCTIONS</h2>
                    <p>{{ $detail->instruction }}</p>
                </div>
            @endforeach
        </section> <!-- END RECIPES DETAILES -->
    @endif

@endsection