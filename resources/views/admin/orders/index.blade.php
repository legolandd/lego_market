@extends('layouts.app')
@section('title', 'Админ.Заказы')
<head>
    <link rel="stylesheet" href="{{asset('css/admin-orders.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
@section('content')
    <div class="header">
        <h1>Мониторинг заказов</h1>
        <div class="filter">
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <select name="status" onchange="this.form.submit()">
                    <option value="">Все</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новые</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Собранные</option>
                    <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Отправленные</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Доставленные</option>
                </select>
            </form>
        </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Вернуться к админ-панели</a>

    <table class="table">
        <thead>
        <tr>
            <th>Имя пользователя</th>
            <th>Метод доставки</th>
            <th>Адрес</th>
            <th>Дата/время доставки</th>
            <th>Оплата</th>
            <th>Общая сумма</th>
            <th>Статус</th>
            <th>Товары</th>
            <th>Изменить статус</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->delivery_method === 'courier' ? 'Курьером' : 'Самовывоз' }}</td>
                <td>{{ $order->address ?? 'Не указан' }}</td>
                <td>{{ $order->delivery_date }} {{ $order->delivery_time }}</td>
                <td>{{ $order->payment_method === 'cash' ? 'Наличными' : 'Картой' }}</td>
                <td>{{ $order->total_price }} ₽</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    @foreach ($order->items as $item)
                        <p>{{ $item->legoSet->name }} (x{{ $item->quantity }}) - {{ $item->price }} ₽</p>
                    @endforeach
                </td>
                <td>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PUT')

                        @php
                            // Определяем следующий статус в зависимости от текущего
                            $statusMap = [
                                'new' => ['value' => 'processing', 'label' => 'Собрать'],
                                'processing' => ['value' => 'shipped', 'label' => 'Отправить'],
                                'shipped' => ['value' => 'delivered', 'label' => 'Доставить'],
                            ];
                        @endphp

                            <!-- Отображаем кнопку только если есть следующий статус -->
                        @if (array_key_exists($order->status, $statusMap))
                            @php
                                $nextStatus = $statusMap[$order->status];
                            @endphp
                            <button type="submit" name="status" value="{{ $nextStatus['value'] }}" class="btn btn-primary">
                                {{ $nextStatus['label'] }}
                            </button>
                        @endif
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
@endsection
