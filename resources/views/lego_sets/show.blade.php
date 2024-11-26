@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{asset('css/vertical-buttons.css')}}">
</head>
<body>
<div class="container">
    <h1>{{ $legoSet->name }}</h1>

    <!-- Слайдер изображений -->
        <div class="carousel">
                <div>
                    <!-- Slider main container -->
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach($images as $image)
                            <div class="swiper-slide"><img src="{{ asset('storage/' . $image->image_url) }}" alt="..." class="slider-image-wrapper"></div>
                            @endforeach
                        </div>

                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>

        </div>


    <p>{{ $legoSet->description }}</p>

    <!-- Характеристики -->
    <ul>
        <li>Цена: {{ $legoSet->price }} ₽</li>
        <li>Рекомендуемый возраст: {{ $legoSet->recommended_age }}+</li>
        <li>Количество деталей: {{ $legoSet->piece_count }}</li>
    </ul>

    <!-- Кнопка добавления в корзину -->
    @auth
        <form action="{{ route('cart.add', $legoSet) }}" method="POST" class="mb-3">
            @csrf
            <div>
                <label for="quantity">Количество:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1">
            </div>
            <button type="submit" class="btn btn-success">Добавить в корзину</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Войдите</a>, чтобы добавить товар в корзину.</p>
    @endauth

    <!-- Отзывы -->
    <h3>Отзывы</h3>
    @foreach($reviews as $review)
        <div class="review mb-3">
            <strong>{{ $review->user->name }}</strong> - {{ $review->rating }}⭐
            <p><strong>Достоинства:</strong> {{ $review->pros }}</p>
            <p><strong>Недостатки:</strong> {{ $review->cons }}</p>
            <p>{{ $review->comment }}</p>
        </div>
    @endforeach

    <!-- Добавить отзыв -->
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
                <input type="number" name="rating" id="rating" class="form-control" min="1" max="5">
            </div>
            <button type="submit" class="btn btn-primary">Оставить отзыв</button>
        </form>
    @endauth
</div>

</body>
</html>
