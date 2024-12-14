@extends('layouts.app')

@section('title', 'Оформление заказа')
<head>
    <link rel="stylesheet" href="{{asset('css/order.css')}}">
</head>
@section('content')
    <div class="steps">
        <div class="step">1. Моя корзина</div>
        <div class="step active">2. Оформление заказа</div>
        <div class="step">3. Готово</div>
    </div>
    <form method="POST" action="{{ route('createOrder') }}">
        @csrf
        <div class="checkout-process">
            <!-- Личные данные -->
            <div class="user-data">
                <h2>Ваши данные</h2>

                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" name="phone" id="phone" value="{{ $user->phone }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" required>
                </div>

                <!-- Способ получения -->
                <h3>Способ получения</h3>
                <div class="delivery-methods">
                    <label>
                        <input type="radio" name="delivery_method" value="courier" checked>
                        Доставка курьером - 390 ₽
                    </label>
                    <label>
                        <input type="radio" name="delivery_method" value="pickup">
                        Самовывоз - Бесплатно
                    </label>
                </div>

                <!-- Адрес -->
                <h3>Адрес доставки</h3>
                <div class="address-fields">
                    <div class="form-group">
                        <label for="city">Город</label>
                        <select name="address[city]" id="city" required>
                            <option value="Москва">Москва</option>
                            <option value="Санкт-Петербург">Санкт-Петербург</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="street">Улица</label>
                        <select name="address[street]" id="street" required>
                            <option value="Ленина">Ленина</option>
                            <option value="Советская">Советская</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="address[house]" placeholder="Дом" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="address[flat]" placeholder="Квартира" required>
                    </div>
                </div>

                <!-- Дата и время -->
                <h3>Выберите дату</h3>
                <input type="date" name="delivery_date" id="delivery_date">

                <h3>Выберите время доставки</h3>
                <select name="delivery_time" required>
                    <option value="08:00-10:00">08:00-10:00</option>
                    <option value="10:00-12:00">10:00-12:00</option>
                </select>

                <!-- Способ оплаты -->
                <h3>Выберите способ оплаты</h3>
                <select name="payment_method" required>
                    <option value="cash">Наличными при получении</option>
                    <option value="card">Картой при получении</option>
                </select>

            </div>
            <div class="order">
                <!-- Список товаров -->
                <div class="title">
                    <h2>Ваш заказ</h2>
                </div>
                <div class="order-summary">
                    <ul>
                        @foreach($cartItems as $item)
                            <li>
                                {{ $item->legoset->name }} - {{ $item->legoset->price }} ₽ x {{ $item['quantity'] }}
                            </li>
                        @endforeach
                    </ul>
                    <p>Доставка: {{ $deliveryCost }} ₽</p>
                    <h3>Итого: {{ $total }} ₽</h3>

                    <button type="submit" class="submit-btn">Оформить заказ</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        const today = new Date();
        today.setDate(today.getDate() + 3);

        const minDate = today.toISOString().split('T')[0];

        document.getElementById('delivery_date').setAttribute('min', minDate);
    </script>
@endsection
