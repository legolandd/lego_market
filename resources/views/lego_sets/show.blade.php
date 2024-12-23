@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{asset('css/vertical-buttons.css')}}">
</head>
@section('content')

    <div class="carousel">
        <h1>LEGO {{$legoSet->series->name}} {{ $legoSet->name }}</h1>
        <div class="product-container">
            <!-- Левая часть: изображения -->
            @if(count($images)>1)
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
            @endif
            <!-- Центральная часть: главное изображение -->
            <div class="main-image-container">
                <img src="{{ asset('storage/' . ($images[0]->image_url ?? '')) }}"
                     alt="Main Product Image"
                     id="mainImage"
                     class="main-image">
            </div>

            <!-- Правая часть: информация о товаре -->
            <div class="product-info">
                <div class="title_and_favorite">
                    <h3>{{$legoSet->price - $legoSet->price * $legoSet->discount/100}} ₽</h3>
                    @if($legoSet->discount > 0)
                        <p class="old-price">{{ $legoSet->price }} ₽</p>
                    @endif
                    @if(Auth::check() && Auth::user()->favorites->contains('lego_set_id', $legoSet->id))
                        <!-- Удалить из избранного -->
                        <form action="{{ route('favorites.destroy', $legoSet->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="cart-like-button" type="submit">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 23.8959C15.3602 23.8954 15.2219 23.8672 15.0931 23.8129C14.9642 23.7586 14.8475 23.6792 14.7495 23.5794L8.58634 17.2617C7.63679 16.2759 7.10629 14.9604 7.10629 13.5917C7.10629 12.2229 7.63679 10.9075 8.58634 9.92166C9.05352 9.43819 9.6134 9.05389 10.2325 8.79173C10.8516 8.52957 11.5172 8.39494 12.1895 8.39588H12.1908C13.4094 8.39379 14.5866 8.83802 15.5 9.64466C16.4141 8.8378 17.592 8.39357 18.8112 8.39588C19.4834 8.39486 20.1494 8.52945 20.7683 8.7916C21.3872 9.05374 21.9468 9.43805 22.4138 9.92153C23.3636 10.9072 23.8943 12.2227 23.8943 13.5915C23.8943 14.9604 23.3636 16.2759 22.4138 17.2616L16.2512 23.5786C16.1537 23.6792 16.0369 23.7591 15.9079 23.8136C15.7788 23.8681 15.6401 23.8961 15.5 23.8959ZM12.1895 9.68755C11.6896 9.68716 11.1948 9.78755 10.7346 9.98271C10.2743 10.1779 9.85819 10.4638 9.51098 10.8234C8.79478 11.567 8.39465 12.5592 8.39465 13.5916C8.39465 14.624 8.79478 15.6162 9.51098 16.3597L15.5 22.4989L21.4891 16.3597C22.2056 15.6163 22.606 14.6241 22.606 13.5916C22.606 12.5591 22.2056 11.5668 21.4891 10.8234C21.1421 10.4638 20.726 10.1778 20.2659 9.98264C19.8058 9.78747 19.311 9.68711 18.8112 9.68755C18.3114 9.6872 17.8166 9.78761 17.3564 9.98277C16.8963 10.1779 16.4802 10.4639 16.133 10.8234L15.5 11.4724L14.8671 10.8234C14.5201 10.4639 14.1042 10.1781 13.6443 9.98291C13.1844 9.78775 12.6891 9.68729 12.1895 9.68755ZM15.5 30.3542C12.5622 30.3542 9.69027 29.483 7.24752 27.8508C4.80476 26.2186 2.90086 23.8987 1.77659 21.1845C0.65231 18.4702 0.358148 15.4836 0.931299 12.6021C1.50445 9.72072 2.91917 7.07396 4.99657 4.99657C7.07396 2.91917 9.72072 1.50445 12.6021 0.931299C15.4836 0.358148 18.4702 0.65231 21.1845 1.77659C23.8987 2.90086 26.2186 4.80476 27.8508 7.24752C29.483 9.69027 30.3542 12.5622 30.3542 15.5C30.3498 19.4383 28.7834 23.214 25.9987 25.9987C23.214 28.7834 19.4383 30.3498 15.5 30.3542ZM15.5 1.93755C12.8176 1.93755 10.1955 2.73297 7.96513 4.22324C5.73478 5.71351 3.99644 7.83168 2.96993 10.3099C1.94342 12.7881 1.67483 15.5151 2.19815 18.146C2.72146 20.7768 4.01316 23.1934 5.90991 25.0902C7.80666 26.9869 10.2233 28.2786 12.8541 28.802C15.485 29.3253 18.212 29.0567 20.6902 28.0302C23.1684 27.0037 25.2866 25.2653 26.7769 23.035C28.2671 20.8046 29.0625 18.1825 29.0625 15.5C29.0584 11.9043 27.6282 8.45705 25.0856 5.91448C22.543 3.37192 19.0958 1.94168 15.5 1.93755Z" fill="red" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <!-- Добавить в избранное -->
                        <form action="{{ route('favorites.store', $legoSet->id) }}" method="POST">
                            @csrf
                            <button class="cart-like-button" type="submit">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 23.8959C15.3602 23.8954 15.2219 23.8672 15.0931 23.8129C14.9642 23.7586 14.8475 23.6792 14.7495 23.5794L8.58634 17.2617C7.63679 16.2759 7.10629 14.9604 7.10629 13.5917C7.10629 12.2229 7.63679 10.9075 8.58634 9.92166C9.05352 9.43819 9.6134 9.05389 10.2325 8.79173C10.8516 8.52957 11.5172 8.39494 12.1895 8.39588H12.1908C13.4094 8.39379 14.5866 8.83802 15.5 9.64466C16.4141 8.8378 17.592 8.39357 18.8112 8.39588C19.4834 8.39486 20.1494 8.52945 20.7683 8.7916C21.3872 9.05374 21.9468 9.43805 22.4138 9.92153C23.3636 10.9072 23.8943 12.2227 23.8943 13.5915C23.8943 14.9604 23.3636 16.2759 22.4138 17.2616L16.2512 23.5786C16.1537 23.6792 16.0369 23.7591 15.9079 23.8136C15.7788 23.8681 15.6401 23.8961 15.5 23.8959ZM12.1895 9.68755C11.6896 9.68716 11.1948 9.78755 10.7346 9.98271C10.2743 10.1779 9.85819 10.4638 9.51098 10.8234C8.79478 11.567 8.39465 12.5592 8.39465 13.5916C8.39465 14.624 8.79478 15.6162 9.51098 16.3597L15.5 22.4989L21.4891 16.3597C22.2056 15.6163 22.606 14.6241 22.606 13.5916C22.606 12.5591 22.2056 11.5668 21.4891 10.8234C21.1421 10.4638 20.726 10.1778 20.2659 9.98264C19.8058 9.78747 19.311 9.68711 18.8112 9.68755C18.3114 9.6872 17.8166 9.78761 17.3564 9.98277C16.8963 10.1779 16.4802 10.4639 16.133 10.8234L15.5 11.4724L14.8671 10.8234C14.5201 10.4639 14.1042 10.1781 13.6443 9.98291C13.1844 9.78775 12.6891 9.68729 12.1895 9.68755ZM15.5 30.3542C12.5622 30.3542 9.69027 29.483 7.24752 27.8508C4.80476 26.2186 2.90086 23.8987 1.77659 21.1845C0.65231 18.4702 0.358148 15.4836 0.931299 12.6021C1.50445 9.72072 2.91917 7.07396 4.99657 4.99657C7.07396 2.91917 9.72072 1.50445 12.6021 0.931299C15.4836 0.358148 18.4702 0.65231 21.1845 1.77659C23.8987 2.90086 26.2186 4.80476 27.8508 7.24752C29.483 9.69027 30.3542 12.5622 30.3542 15.5C30.3498 19.4383 28.7834 23.214 25.9987 25.9987C23.214 28.7834 19.4383 30.3498 15.5 30.3542ZM15.5 1.93755C12.8176 1.93755 10.1955 2.73297 7.96513 4.22324C5.73478 5.71351 3.99644 7.83168 2.96993 10.3099C1.94342 12.7881 1.67483 15.5151 2.19815 18.146C2.72146 20.7768 4.01316 23.1934 5.90991 25.0902C7.80666 26.9869 10.2233 28.2786 12.8541 28.802C15.485 29.3253 18.212 29.0567 20.6902 28.0302C23.1684 27.0037 25.2866 25.2653 26.7769 23.035C28.2671 20.8046 29.0625 18.1825 29.0625 15.5C29.0584 11.9043 27.6282 8.45705 25.0856 5.91448C22.543 3.37192 19.0958 1.94168 15.5 1.93755Z" fill="black" />
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="product-info-p">
                    <p>Осталось в наличии: {{$legoSet->stock}} шт.</p>
                    <p>Доставка от 3 дней</p>
                </div>
                <div class="product-info-form">
                    @auth
                        <form action="{{ route('cart.add', $legoSet) }}" method="POST">
                            @csrf
                            <div class="quantity-container">
                                <label for="quantity"></label>
                                <div class="quantity-controls">
                                    <div class="btn-minus" onclick="changeQuantity(-1)"></div>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" readonly>
                                    <div class="btn-plus" onclick="changeQuantity(1)"></div>
                                </div>
                            </div>
                            <button type="submit" class="add-to-cart">Купить</button>

                        </form>
                </div>
                @else
                    <p><a href="{{ route('login') }}">Войдите</a>, чтобы добавить товар в корзину.</p>
                @endauth
            </div>
        </div>
    </div>
    <div class="info-block">
        <!--Кнопки-->
        <div class="tabs">
            <button class="tab-button active" data-tab="about">О товаре</button>
            <button class="tab-button" data-tab="reviews">Отзывы</button>
        </div>
        <!--Кнопки-->

        <!--Описание-->
        <div class="tab-content">
            <div class="tab-content-text" id="about">
                <ul>
                    <li>
                        <div class="tab-content-text-image">
                            <img src="{{asset('lego_images/Price.svg')}}" alt="Цена">
                        </div>
                        <div>
                            <p>Цена:</p>
                            <p><span>{{ $legoSet->price }} ₽</span></p>
                        </div>
                    </li>
                    <li>
                        <div class="tab-content-text-image">
                            <img src="{{asset('lego_images/Age.svg')}}" alt="Рекомендуемый возраст">
                        </div>
                        <div>
                            <p>Рекомендуемый возраст:</p>
                            <p><span>{{ $legoSet->recommended_age }}+</span></p>
                        </div>
                    </li>
                    <li>
                        <div class="tab-content-text-image">
                            <img src="{{asset('lego_images/Brick.svg')}}" alt="Количество деталей">
                        </div>
                        <div>
                            <p>Количество деталей:</p>
                            <p><span>{{ $legoSet->piece_count }}</span></p>
                        </div>
                    </li>
                </ul>
                <div>
                    <h3>Описание</h3>
                    <p>{{ $legoSet->description }}</p>
                </div>
            </div>
        </div>
        <!--Описание-->

        <!--Отзывы-->
        <div class="tab-content">
            <div class="tab-content-text d-none" id="reviews">
                <div class="mama">
                    <h3>Отзывы</h3>
                    <!-- Форма добавления отзыва -->
                    <!-- Кнопка для открытия модального окна -->
                    <button id="openModalButton" class="btn-primary">Оставить отзыв</button>
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
                        </div>
                        <div class="comments review-blocks">
                            <p><b>Комментарий</b></p>
                            <span>{{ $review->comment }}</span>
                        </div>
                        <span class="first-name">{{ $review->user->name }}</span>

                        <!-- Ответ администратора -->
                        @if ($review->adminReply)
                            <div class="admin-reply">
                                <p><b>Ответ администратора:</b></p>
                                <span>{{ $review->adminReply->reply }}</span>
                            </div>
                        @endif

                        @if (auth()->user() && auth()->user()->role === 'admin')
                            <form action="{{ route('reviews.reply', $review) }}" method="POST">
                                @csrf
                                <textarea name="reply" rows="3" class="admin-reply-textarea" placeholder="Напишите ответ...">{{ $review->adminReply->reply ?? '' }}</textarea>
                                <button type="submit" class="btn-primary">Сохранить</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
            <!--Отзывы-->

            <!-- Модальное окно -->
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close-button" id="closeModalButton"><img src="{{ asset('lego_images/close-modal.svg') }}"></span>
                    <h2>Добавить отзыв</h2>

                    <form action="{{ route('reviews.store', $legoSet) }}" method="POST">
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
                        <button type="submit" class="add-to-cart">Отправить отзыв</button>
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
