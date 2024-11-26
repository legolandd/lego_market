@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{asset('css/vertical-buttons.css')}}">
</head>
@section('content')
    <h1>{{ $legoSet->name }}</h1>

    <!-- Слайдер изображений -->
        <div class="carousel">
            <div class="product-container">
                <!-- Vertical slider -->
                <div class="slider-container">
                    <div class="slider">
                        @foreach($images as $image)
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image" onclick="changeMainImage(this)">
                        @endforeach
                    </div>
                </div>

                <!-- Main image -->
                <div>
                    <img src="{{ asset('storage/' . $images[0]->image_url ?? '') }}" alt="Main Product Image" id="mainImage" class="main-image">
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
    <script>
        // Function to change the main image
        function changeMainImage(imageElement) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = imageElement.src;
        }
    </script>
@endsection
