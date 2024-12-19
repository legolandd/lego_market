@extends('layouts.app')
@section('title', 'Админ.Заказы')
<head>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
@section('content')
    <div class="profile-container">
        <aside class="sidebar">
            <h2 class="title">Личный кабинет</h2>
            <ul>
                <li>
                    <a href="#" class="text active" data-tab="profile">Профиль</a>
                </li>
                <li>
                    <a href="#" class="text" data-tab="orders">Мои заказы @if ($ordersCount > 0) ({{ $ordersCount }}) @endif</a>
                </li>
                @if(auth()->user()->role == 'admin')
                <li>
                    <a href="{{route('admin.dashboard')}}">Панель администратора</a>
                </li>
                @endif
            </ul>
            <a href="{{route('logout')}}" class="logout">Выйти</a>
        </aside>

        <main>
            <div id="profile-tab" class="tab-content active">
                <h2 class="title">Профиль</h2>
                <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')
                    <div class="profile-form-inputs">
                        <h2>Личная информация</h2>
                        <div class="input-group">
                            <label for="name" class="text">Имя:</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="input-group">
                            <label for="email" class="text">Email:</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="input-group">
                            <label for="phone" class="text">Телефон:</label>
                            <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}" required>
                        </div>
                        <div class="input-group">
                            <label class="text">Пол:</label>
                            <div class="checkout-content">
                                <label>
                                    <input
                                        type="radio"
                                        name="gender"
                                        class="text"
                                        value="male"
                                        {{ auth()->user()->gender == 'male' ? 'checked' : '' }}
                                    >
                                    Мужской
                                </label>
                                <label>
                                    <input
                                        type="radio"
                                        name="gender"
                                        class="text"
                                        value="female"
                                        {{ auth()->user()->gender == 'female' ? 'checked' : '' }}
                                    >
                                    Женский
                                </label>
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="main-button">Сохранить изменения</button>
                </form>
            </div>

            <!-- Вкладка "Мои заказы" -->
            <div id="orders-tab" class="tab-content">
                <h2 class="title">Мои заказы</h2>
                <div class="orders-block">
                    @foreach($orders as $order)
                        <table class="order-item">
                            <thead>
                            <tr>
                                <th>Номер заказа:</th>
                                <th>Дата заказа:</th>
                                <th>Название товара:</th>
                                <th>Количество:</th>
                                <th>Цена:</th>
                                <th>Сумма:</th>
                                <th>Статус:</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td rowspan="{{ $order->items->count() }}">{{ $order->id }}</td>
                                <td rowspan="{{ $order->items->count() }}">{{ $order->created_at->translatedFormat('d F Y') }}</td>
                            @foreach ($order->items as $index => $item)
                                @if ($index > 0)
                                    <tr>
                                        @endif
                                        <td>{{ $item->legoSet->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        @if ($index == 0)
                                            <td rowspan="{{ $order->items->count() }}">{{ $order->total_price }}</td>
                                            <td rowspan="{{ $order->items->count() }}">
                                                <span class="{{ $order->status == 'delivered' ? 'status-success' : 'status-cancelled' }}">{{ $order->status }}</span>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    </tr>
                            </tbody>
                        </table>
                    @endforeach
                        {{ $orders->links() }}
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/profile-tabs.js') }}"></script>
@endsection
