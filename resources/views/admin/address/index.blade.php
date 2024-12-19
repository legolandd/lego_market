@extends('layouts.app')
@section('title', 'Админ.Лего-серии')
<head>
    <link rel="stylesheet" href="{{asset('css/admin-legoseries.css')}}">
    <link rel="stylesheet" href="{{asset('css/order.css')}}">
</head>
@section('content')
    <h1>LEGO Серии</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Вернуться к админ-панели</a>

    <div class="form-container">
        <form action="{{ route('admin.address.store') }}" method="POST">
            @csrf
            <div class="address-fields">
                <div class="form-group">
                    <label for="city">Город</label>
                    <input type="text" name="address[city]" id="city" placeholder="Город" required>
                </div>
                <div class="form-group">
                    <label for="street">Улица/Проспект</label>
                    <input type="text" name="address[street]" id="street" placeholder="Улица/Проспект" required>
                </div>
                <div class="form-group">
                    <input type="text" name="address[house]" placeholder="Дом" required>
                </div>
                <div class="form-group">
                    <input type="text" name="address[flat]" placeholder="Квартира" required>
                </div>
                <button type="submit">Добавить адрес</button>
            </div>
        </form>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($addresses as $address)
            <tr>
                <td>{{ $address->id }}</td>
                <td>{{ $address->address }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
