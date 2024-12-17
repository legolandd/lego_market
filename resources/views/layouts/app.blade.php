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
                <a href="/">
                    <img src="{{asset('lego_images/logo.svg')}}">
                </a>
            </div>

            <form method="GET" action="{{ route('lego_sets.index') }}" class="search">
                <input type="search" name="search" class="search-input" placeholder="Найти наборы или серии...">
                <button type="submit" class="search-button"><img src="{{asset('lego_images/search.svg')}}" alt="Search"></button>
            </form>

            <div class="icons">
                <div class="icon phone" data-tooltip="Контактный номер">
                    <img src="{{asset('lego_images/phone.svg')}}" class="phone-img">
                    <a href="tel:89009999999">8(900)999-99-99</a>
                </div>
                <div class="icon favorite" data-tooltip="Избранное">
                    <a href="{{route('favorites.index')}}"><img src="{{asset('lego_images/favorite.svg')}}"></a>
                </div>
                <div class="icon cart" data-tooltip="Корзина">
                    <a href="/cart"><img src="{{asset('lego_images/cart.svg')}}"></a>
                </div>
                @guest
                    <div class="login" data-tooltip="Войти">
                        <a href="{{ route('login') }}" class="profile">Войти</a>
                    </div>
                @else
                    <div class="login" data-tooltip="Профиль">
                        <a href="{{ route('profile') }}" class="profile">{{ auth()->user()->name }}</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>

<div class="container">
    @yield('content')

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
<div class="toast-container" id="toast-container"></div>
<script>
    // Функция для добавления уведомления
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;

        // Добавляем уведомление в контейнер
        container.appendChild(toast);

        // Удаляем уведомление через 5 секунд
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    // Проверяем уведомления из сессии и отображаем их
    @if (session('success'))
    showToast("{{ session('success') }}", 'success');
    @endif

    @if (session('error'))
    showToast("{{ session('error') }}", 'error');
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    showToast("{{ $error }}", 'error');
    @endforeach
    @endif
</script>
@include('layouts.footer')
</body>
</html>
