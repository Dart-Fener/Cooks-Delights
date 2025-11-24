@extends('layouts.theme')

@section('content')

    <!-- PAGE TITLE -->
    <div class="page-title">
        <h3>Subscribe</h3>
        <nav class="page-title-nav">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <h4>Subscribe</h4>
        </nav>
    </div> <!-- END PAGE TITLE -->

    <!-- SUBSCRIBE -->
    <section id="subscribe">
        <button class="emptyBack">SUBSCRIBE</button>
        <h2>JOIN THE FUN SUBSCRIBE NOW!</h2>
        <p>Subscribe to our newsletter for a weekly serving of recipes, cooking tips, and exclusive insights straight to your inbox.</p>
        <form method="post" action="{{ route('subscribe.save') }}">
            @csrf
            <input type="email" name="email" id="email" placeholder="Email Address" required="@">
            <input type="submit" value="SUBSCRIBE">
        </form>
    </section> <!-- END SUBSCRIBE -->

@endsection