@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{asset('css/vertical-buttons.css')}}">
</head>
@section('content')

    <div class="carousel container">
        <h1>{{ $legoSet->name }}</h1>
        <div class="product-container">
            <!-- Левая часть: изображения -->
            <div class="slider-container">
                <button class="arrow" id="upArrow" onclick="scrollSlider(-1)"><img src="{{asset('lego_images/slider-arrow-up.svg')}}" alt=""></button>
                <div class="slider-wrapper">
                    <div class="slider-images" id="sliderImages">
                        @foreach($images as $image)
                            <img
                                src="{{ asset('storage/' . $image->image_url) }}"
                                alt="Product Image"
                                onclick="changeMainImage('{{ asset('storage/' . $image->image_url) }}')">
                        @endforeach
                    </div>
                </div>
                <button class="arrow" id="downArrow" onclick="scrollSlider(1)"><img src="{{asset('lego_images/slider-arrow-down.svg')}}" alt=""></button>
            </div>

            <!-- Центральная часть: главное изображение -->
            <div class="main-image-container">
                <img src="{{ asset('storage/' . ($images[0]->image_url ?? '')) }}"
                     alt="Main Product Image"
                     id="mainImage"
                     class="main-image">
            </div>

            <!-- Правая часть: информация о товаре -->
            <div class="product-info">
                <ul>
                    <li>Цена: {{ $legoSet->price }} ₽</li>
                    <li>Рекомендуемый возраст: {{ $legoSet->recommended_age }}+</li>
                    <li>Количество деталей: {{ $legoSet->piece_count }}</li>
                </ul>
                @auth
                    <form action="{{ route('cart.add', $legoSet) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="quantity-container">
                            <label for="quantity">Количество:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1">
                        </div>
                        <button type="submit" class="btn btn-success">Добавить в корзину</button>
                    </form>
                @else
                    <p><a href="{{ route('login') }}">Войдите</a>, чтобы добавить товар в корзину.</p>
                @endauth
            </div>
        </div>
    </div>
    <div class="tabs">
        <button class="tab-button active" data-tab="about">О товаре</button>
        <button class="tab-button" data-tab="characteristics">Характеристики</button>
        <button class="tab-button" data-tab="reviews">Отзывы</button>
    </div>
    <div class="tab-content">
        <div class="tab-content-text" id="about">
            <p>Описание товара: {{ $legoSet->description }}</p>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-content-text d-none" id="characteristics">
            <h3>Характеристики</h3>
            <ul>
                <li><b>Цена:</b> {{ $legoSet->price }} ₽</li>
                <li><b>Рекомендуемый возраст:</b> {{ $legoSet->recommended_age }}+</li>
                <li><b>Количество деталей:</b> {{ $legoSet->piece_count }}</li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-content-text d-none" id="reviews">
            <h3>Отзывы</h3>
            @foreach($reviews as $review)
                <div class="review mb-3">
                    <strong>{{ $review->user->name }}</strong>
                    @for ($i = 0; $i < $review->rating; $i++)
                        ⭐
                    @endfor
                    <p><strong>Достоинства:</strong> {{ $review->pros }}</p>
                    <p><strong>Недостатки:</strong> {{ $review->cons }}</p>
                    <p>{{ $review->comment }}</p>
                </div>
            @endforeach

            <!-- Форма добавления отзыва -->
            @auth
                <form action="{{ route('reviews.store', $legoSet) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="pros">Достоинства:</label>
                        <input type="text" name="pros" id="pros" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="cons">Недостатки:</label>
                        <input type="text" name="cons" id="cons" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="comment">Комментарий:</label>
                        <textarea name="comment" id="comment" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="rating">Рейтинг:</label>
                        <div id="star-rating" class="d-flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}" style="cursor: pointer;">
                <img src="{{ asset('lego_images/star-no-fill.svg') }}" alt="Star" class="star-image" width="24" height="24">
            </span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" value="0">
                    </div>
                    <button type="submit" class="btn btn-primary">Оставить отзыв</button>
                    @endauth

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const stars = document.querySelectorAll('#star-rating .star');
                            const ratingInput = document.getElementById('rating');

                            stars.forEach(star => {
                                star.addEventListener('click', () => {
                                    const rating = star.getAttribute('data-value');
                                    ratingInput.value = rating;

                                    // Обновляем изображения звёзд
                                    stars.forEach(s => {
                                        const starImage = s.querySelector('.star-image');
                                        if (parseInt(s.getAttribute('data-value')) <= rating) {
                                            starImage.src = "{{ asset('lego_images/star-fill.svg') }}";
                                        } else {
                                            starImage.src = "{{ asset('lego_images/star-no-fill.svg') }}";
                                        }
                                    });
                                });
                            });
                        });
                    </script>


        </div>
    </div>



    <script>
        let currentIndex = 0;

        function scrollSlider(direction) {
            const slider = document.getElementById('sliderImages');
            const images = slider.children;
            const imageHeight = 110; // Высота картинки (100px) + отступ (10px)
            const visibleImages = 3; // Количество видимых картинок

            // Рассчитываем максимальный индекс прокрутки
            const maxIndex = Math.max(0, images.length - visibleImages);

            // Обновляем текущий индекс
            currentIndex += direction;
            currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));

            // Обновляем слайдер
            slider.style.transform = `translateY(-${currentIndex * imageHeight}px)`;

            // Обновляем состояние кнопок
            document.getElementById('upArrow').disabled = currentIndex === 0;
            document.getElementById('downArrow').disabled = currentIndex === maxIndex;
        }

        function changeMainImage(imageUrl) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = imageUrl;
        }

        // Инициализация состояния
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.getElementById('sliderImages').children.length;
            document.getElementById('upArrow').disabled = currentIndex === 0;
            document.getElementById('downArrow').disabled = images <= 3;
        });

        document.addEventListener('DOMContentLoaded', () => {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content-text');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Убираем активный класс со всех кнопок
                    tabButtons.forEach(btn => btn.classList.remove('active'));

                    // Скрываем все табы
                    tabContents.forEach(content => content.classList.add('d-none'));

                    // Показываем выбранный таб и добавляем активный класс на кнопку
                    const targetTab = button.getAttribute('data-tab');
                    document.getElementById(targetTab).classList.remove('d-none');
                    button.classList.add('active');
                });
            });
        });

    </script>
@endsection
