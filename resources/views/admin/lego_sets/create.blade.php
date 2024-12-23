@extends('layouts.app')
@section('title', 'Создание лего-набора')
<head>
    <link rel="stylesheet" href="{{asset('css/admin-legosets-create.css')}}">
</head>
@section('content')
<h1>Создать новый LEGO набор</h1>

<form action="{{ route('admin.lego_sets.store') }}" class="lego-set-form" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label>Серия</label>
        <select name="series_id" class="form-control" required>
            @foreach ($series as $serie)
                <option value="{{ $serie->id }}">{{ $serie->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Цена</label>
        <input type="number" name="price" class="form-control" min="0" required>
    </div>

    <div class="form-group">
        <label>Рекомендуемый возраст</label>
        <input type="number" name="recommended_age" class="form-control" required min="1">
    </div>

    <div class="form-group">
        <label>Количество деталей</label>
        <input type="number" name="piece_count" class="form-control" required min="1">
    </div>

    <div class="form-group">
        <label>Количество на складе</label>
        <input type="number" name="stock" class="form-control" required min="0">
    </div>

    <div class="form-group">
        <label>Выберите интересы:</label>
        <div>
            @foreach ($interests as $interest)
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="interests[]"
                        value="{{ $interest->id }}"
                        id="interest_{{ $interest->id }}"
                        class="form-check-input">
                    <label class="form-check-label" for="interest_{{ $interest->id }}">
                        {{ $interest->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>


    <div class="form-group">
        <label>Новинка</label>
        <input type="checkbox" name="is_new" value="1">
    </div>

    <div class="form-group">
        <label>На распродаже</label>
        <input type="checkbox" name="is_sale" value="1">
    </div>

    <div class="form-group">
        <label>Скидка (%)</label>
        <input type="number" name="discount" class="form-control" min="0" max="100">
    </div>

    <div class="form-group">
        <label>Изображения</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-success">Создать набор</button>
</form>
@endsection
