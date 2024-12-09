@extends('layouts.app')

@section('title', 'Главная')
<head>
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">
</head>
@section('content')
    <div class="steps">
        <div class="step active">1. Моя корзина</div>
        <div class="step">2. Оформление заказа</div>
        <div class="step">3. Готово</div>
    </div>

    <!-- Основной контент -->
    <div class="cart-layout">
        <!-- Колонка: Моя корзина -->
        <div class="cart-column">
            @foreach($cartItems as $item)
                <div class="cart-item">

                    <img src="{{ asset('storage/' . $item->legoSet->images->first()->image_url) }}" alt="{{ $item->legoSet->name }}" class="item-image">
                    <div class="item-details">
                        <h4>{{ $item->legoSet->name }}</h4>
                        <p>Цена: {{ $item->legoSet->price }} ₽</p>
                        <form action="{{ route('cart.update', $item) }}" method="POST"  class="quantity-form">
                            @csrf
                            <label for="quantity-{{ $item->id }}">Количество:</label>
                            <select name="quantity" id="quantity-{{ $item->id }}" onchange="this.form.submit()" class="quantity-selector">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>

                        </form>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Колонка: Оформление заказа -->
        <div class="checkout-column">
            <h3>Товары ({{ count($cartItems) }})</h3>
            <p>Итого: {{ $cartTotal }} ₽</p>
            <a href="{{route('order')}}">
                <button class="main-button">Оформить заказ</button>
            </a>
        </div>

        <!-- Колонка: Готово -->
        <div class="summary-column">
            <p class="summary-text">После оформления заказа вы можете следить за его статусом в своём профиле.</p>
            <p>Спасибо за выбор нашего магазина!</p>
        </div>
    </div>
@endsection
