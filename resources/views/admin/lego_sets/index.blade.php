@extends('layouts.app')
@section('title', 'Админ.Лего-наборы')
<head>
    <link rel="stylesheet" href="{{asset('css/admin-legosets.css')}}">
</head>
@section('content')
<h1>LEGO Наборы</h1>
<div class="buttons">
<a href="{{ route('admin.lego_sets.create') }}" class="btn btn-primary">Создать новый набор</a>
<a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Вернуться к админ-панели</a>
</div>

<table class="table mt-3">
    <thead>
    <tr>
        <th>Название</th>
        <th>Серия</th>
        <th>Цена</th>
        <th>Количество</th>
        <th>Новинка</th>
        <th>На распродаже</th>
        <th>Скидка (%)</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($legoSets as $legoSet)
        <tr>
            <td>{{ $legoSet->name }}</td>
            <td>{{ $legoSet->series->name }}</td>
            <td>{{ $legoSet->price }}</td>
            <td>{{ $legoSet->stock }}</td>
            <td>{{ $legoSet->is_new ? 'Да' : 'Нет' }}</td>
            <td>{{ $legoSet->is_sale ? 'Да' : 'Нет' }}</td>
            <td>{{ $legoSet->discount ?? 0 }}</td>
            <td>
                <a href="{{ route('admin.lego_sets.edit', $legoSet->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                <form action="{{ route('admin.lego_sets.destroy', $legoSet) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить этот набор?')">Удалить</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
