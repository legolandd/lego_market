<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Главная')</title>
    @yield('style')
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
</head>
<body>
<header>
    <div class="container">
        <div class="header_wrapper">
            <div class="logo">
                <a href="/"><img src="{{asset('lego_images/logo.svg')}}"></a>
            </div>
            <div class="search">
                <form method="GET" action="{{ route('lego_sets.index') }}">
                    <input type="text" name="search" class="search-input" placeholder="Найти наборы или серии...">
                    <button type="submit" class="search-button">
                        <img src="{{ asset('lego_images/search.svg') }}" class="search-img" alt="Искать">
                    </button>
                </form>
            </div>
            <div class="icons">
                <div class="icon phone">
                    <img src="{{asset('lego_images/phone.svg')}}" class="phone-img">
                    <p>8(900)999-99-99</p>
                </div>
                <div class="icon favorite">
                    <img src="{{asset('lego_images/favorite.svg')}}">
                </div>
                <div class="icon cart">
                    <a href="/cart"><img src="{{asset('lego_images/cart.svg')}}"></a>
                </div>
                @guest
                    <!-- Если пользователь не авторизован -->
                    <div class="login">
                        <a href="{{ route('login') }}">Войти</a>
                    </div>
                @else
                    <!-- Если пользователь авторизован -->
                    <div class="login">
                        <a href="{{ route('profile') }}">{{ auth()->user()->name }}</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session())
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif

<div class="container">
    @yield('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="list-style: none">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        direction: "vertical",
        slidesPerView: 3,
        spaceBetween: 12,
        loop: true,

        // Navigation arrows
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>
@include('layouts.footer')
</body>
</html>
