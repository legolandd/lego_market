<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1>{{ $legoSet->name }}</h1>

    <!-- Слайдер изображений -->
        <div class="carousel">
            @foreach($images as $image)
                <div>
                    <img src="../{{ $image->image_url }}" alt="...">
                </div>
            @endforeach
        </div>


    <p>{{ $legoSet->description }}</p>

    <!-- Характеристики -->
    <ul>
        <li>Цена: {{ $legoSet->price }} ₽</li>
        <li>Рекомендуемый возраст: {{ $legoSet->recommended_age }}+</li>
        <li>Количество деталей: {{ $legoSet->piece_count }}</li>
    </ul>

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
