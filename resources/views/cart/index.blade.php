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
            <!-- Товары в наличии -->
            @foreach($inStockItems as $item)
                <div class="cart-item">
                    <img src="{{ asset('storage/' . $item->legoSet->images->first()->image_url) }}" alt="{{ $item->legoSet->name }}" class="item-image">
                    <div class="item-details">
                        <h4>LEGO {{$item->legoSet->series->name}} {{ $item->legoSet->name }}</h4>
                        <p>Цена: {{ $item->legoSet->price }} ₽</p>
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="quantity-form">
                            @csrf
                            <label for="quantity">Количество:</label>
                            <input type="number" name="quantity" id="quantity-{{ $item->id }}"
                                   value="{{ $item->quantity }}"
                                   min="1" max="10"
                                   onchange="this.form.submit()"
                                   class="quantity-input">
                        </form>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Товары без наличия -->
            @foreach($outOfStockItems as $item)
                <div class="cart-item out-of-stock">
                    <img src="{{ asset('storage/' . $item->legoSet->images->first()->image_url) }}" alt="{{ $item->legoSet->name }}" class="item-image">
                    <div class="item-details">
                        <h4>LEGO {{$item->legoSet->series->name}} {{ $item->legoSet->name }}</h4>
                        <p>Цена: {{ $item->legoSet->price }} ₽</p>
                        <p class="out-of-stock-text">Товара нет в наличии</p>
                        <p>Количество: 0</p>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Колонка: Оформление заказа -->
        @if(count($inStockItems) != 0)
            <div>
                <div class="checkout-column">
                    <h3>Товары ({{ count($inStockItems) }})</h3>
                    <div class="price">
                        <p><b>Итого: {{ $cartTotal }} </b></p>
                        <p>Товары в корзине на сумму: {{ $totalPrice }} ₽</p>
                        <p>Скидка: {{ $totalPrice -  $cartTotal }} ₽</p>
                    </div>
                    <a href="{{route('order')}}">
                        <button class="main-button">Оформить заказ</button>
                    </a>
                </div>
            </div>
        @else
            <div class="checkout-column">
                <p>Корзина пуста</p>
                <a href="{{route('lego_sets.index')}}" class="main-button">За покупками!!!</a>
            </div>
        @endif


        <!-- Колонка: Готово -->
        <div class="summary-column">
            <p class="summary-text">После оформления заказа вы можете следить за его статусом в своём профиле.</p>
            <p>Спасибо за выбор нашего магазина!</p>
        </div>
    </div>

@endsection
