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
                <input type="text" class="search-input">
                <button type="submit" class="search-button">
                <img src="{{asset('lego_images/search.svg')}}" class="search-img">
                </button>
            </div>
            <div class="icons">
                <div class="phone">
                    <img src="{{asset('lego_images/phone.svg')}}" class="phone-img">
                    <p>8(900)999-99-99</p>
                </div>
                <div class="favorite">
                    <img src="{{asset('lego_images/favorite.svg')}}">
                </div>
                <div class="cart">
                    <a href="/cart"><img src="{{asset('lego_images/cart.svg')}}"></a>
                </div>
                <div class="login">
                    <a href="{{route('login')}}">Войти</a>
                </div>
            </div>
        </div>
    </div>
</header>
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
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
</body>
</html>
