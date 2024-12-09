@extends('layouts.app')
@section('title', 'Админ.Заказы')
<head>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
</head>
@section('content')
    <div class="profile-container">
        <aside class="sidebar">
            <h2 class="title">Личный кабинет</h2>
            <ul>
                <li><a href="#" class="text active" data-tab="profile">Профиль</a></li>
                <li>
                    <a href="#" class="text" data-tab="orders">
                        Мои заказы @if ($ordersCount > 0) ({{ $ordersCount }}) @endif
                    </a>
                </li>
                <li><a href="#" class="text" data-tab="favorites">Избранное (1)</a></li>
            </ul>
        </aside>

        <section class="profile-content">
            <div id="profile-tab" class="tab-content active">
                <h2 class="title">Профиль</h2>
                <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')
                    <fieldset>
                        <legend>Личная информация</legend>
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
                            <label>
                                <input type="radio" name="gender" class="text" value="male" {{ auth()->user()->gender == 'male' ? 'checked' : '' }}>
                                Мужской
                            </label>
                            <label>
                                <input type="radio" name="gender" class="text" value="female" {{ auth()->user()->gender == 'female' ? 'checked' : '' }}>
                                Женский
                            </label>
                        </div>
                    </fieldset>
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
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->translatedFormat('d F Y') }}</td>
                            @foreach ($order->items as $item)
                                <td>{{ $item->legoSet->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                            @endforeach
                            <td>{{ $order->total_price }}</td>
                            <td><span class="{{ $order->status == 'Получен' ? 'status-success' : 'status-cancelled' }}">{{ $order->status }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('js/profile-tabs.js') }}"></script>
@endsection
