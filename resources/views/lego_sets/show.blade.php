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
                <button class="arrow" id="downArrow" onclick="scrollSlider(1)"><img src="{{asset('lego_images/slider-arrow-down.svg')}}" alt="slider-arrow"></button>
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
                <div>
                    <h3>{{ $legoSet->price }} ₽</h3>
                </div>
                <div class="product-info-p">
                    <p>Осталось в наличии: {{$legoSet->stock}}</p>
                    <p>Доставка от 3 дней</p>
                </div>
                <div class="product-info-form">
                @auth
                    <form action="{{ route('cart.add', $legoSet) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="quantity-container">
                            <label for="quantity"></label>
                            <div class="quantity-controls">
                                <div class="btn-minus" onclick="changeQuantity(-1)"></div>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" readonly>
                                <div class="btn-plus" onclick="changeQuantity(1)"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn-success mt-3">Купить</button>
                    </form>
                </div>
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
            <div class="mama">
                <h3>Отзывы</h3>
                <!-- Форма добавления отзыва -->
                <!-- Кнопка для открытия модального окна -->
                <button id="openModalButton" class="btn btn-primary">Оставить отзыв</button>
            </div>
            @foreach($reviews as $review)
                <div class="review">
                    <div class="review-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <img src="{{ asset('lego_images/star-fill.svg') }}" alt="Filled Star">
                            @else
                                <img src="{{ asset('lego_images/star-no-fill.svg') }}" alt="Empty Star">
                            @endif
                        @endfor
                    </div>
                    <div class="pluses review-blocks">
                    <p><b>Плюсы</b></p>
                    <span>{{ $review->pros }}</span>
                    </div>
                    <div class="minuses review-blocks">
                        <p><b>Минусы</b></p>
                        <span>{{ $review->cons }}</span>
                    </div><div class="coments review-blocks">
                        <p><b>Коментарий</b></p>
                        <span>{{ $review->comment }}</span>
                    </div>
                    <span class="first-name">{{ $review->user->name }}</span>
                </div>
            @endforeach



            <!-- Модальное окно -->
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close-button" id="closeModalButton"><img src="{{ asset('lego_images/close-modal.svg') }}"></span>
                    <h2>Добавить отзыв</h2>
                    <div class="form-group">
                        <label for="rating">Оценка товара</label>
                        <div id="star-rating-modal" class="d-flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}" style="cursor: pointer;">
                            <img src="{{ asset('lego_images/star-no-fill.svg') }}" alt="Star" class="star-image" width="24" height="24">
                        </span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-modal" value="0">
                    </div>
                    <form action="{{ route('reviews.store', $legoSet) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="pros">Плюсы</label>
                            <input type="text" name="pros" id="pros" class="form-control" required placeholder="Плюсы">
                        </div>
                        <div class="form-group">
                            <label for="cons">Минусы</label>
                            <input type="text" name="cons" id="cons" class="form-control" required placeholder="Минусы">
                        </div>
                        <div class="form-group">
                            <label for="comment">Комментарий:</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4" required placeholder="Коментарий"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Отправить отзыв</button>
                    </form>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const modal = document.getElementById('modal');
                    const openModalButton = document.getElementById('openModalButton');
                    const closeModalButton = document.getElementById('closeModalButton');

                    // Открытие модального окна
                    openModalButton.addEventListener('click', () => {
                        modal.style.display = 'block';
                    });

                    // Закрытие модального окна
                    closeModalButton.addEventListener('click', () => {
                        modal.style.display = 'none';
                    });

                    // Закрытие модального окна при клике вне его
                    window.addEventListener('click', (event) => {
                        if (event.target === modal) {
                            modal.style.display = 'none';
                        }
                    });

                    // Обработка звезд рейтинга
                    const stars = document.querySelectorAll('#star-rating-modal .star');
                    const ratingInput = document.getElementById('rating-modal');

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
        function changeQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value) || 0; // Защита от некорректных данных
            const minValue = parseInt(quantityInput.min) || 1; // Учитываем минимальное значение
            const newValue = currentValue + change;

            // Убедитесь, что значение не меньше минимального
            if (newValue >= minValue) {
                quantityInput.value = newValue;
            }
        }

    </script>
@endsection
