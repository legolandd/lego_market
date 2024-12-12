@extends('layouts.app')
@section('title', 'Админ.Лего-серии')
<head>
    <link rel="stylesheet" href="{{asset('css/admin-legoseries.css')}}">
</head>
@section('content')
    <h1>LEGO Серии</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Вернуться к админ-панели</a>

    <div class="form-container">
        <form action="{{ route('admin.lego_series.store') }}" method="POST">
            @csrf
            <label for="name">Название серии</label>
            <input class="series-input" type="text" id="name" name="name" required placeholder="Введите название серии">
            <button type="submit">Добавить серию</button>
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
        @foreach ($series as $serie)
            <tr>
                <td>{{ $serie->id }}</td>
                <td>{{ $serie->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
