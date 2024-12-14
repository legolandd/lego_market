@extends('layouts.app')
@section('title', 'Создание лего-набора')
<head>
    <link rel="stylesheet" href="{{asset('css/admin-legosets-create.css')}}">
</head>
@section('content')
<h1>Редактировать LEGO набор</h1>

<form action="{{ route('admin.lego_sets.update', $legoSet->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>Название</label>
        <input type="text" name="name" class="form-control" value="{{ $legoSet->name }}" required>
    </div>

    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" class="form-control" required>{{ $legoSet->description }}</textarea>
    </div>

    <div class="form-group">
        <label>Серия</label>
        <select name="series_id" class="form-control" required>
            @foreach ($series as $serie)
                <option value="{{ $serie->id }}" {{ $serie->id == $legoSet->series_id ? 'selected' : '' }}>{{ $serie->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Цена</label>
        <input type="number" name="price" class="form-control" value="{{ $legoSet->price }}" required>
    </div>

    <div class="form-group">
        <label>Рекомендуемый возраст</label>
        <input type="number" name="recommended_age" class="form-control" value="{{ $legoSet->recommended_age }}" required>
    </div>

    <div class="form-group">
        <label>Количество деталей</label>
        <input type="number" name="piece_count" class="form-control" value="{{ $legoSet->piece_count }}" required>
    </div>

    <div class="form-group">
        <label>Количество на складе</label>
        <input type="number" name="stock" class="form-control" value="{{ $legoSet->stock }}" required min="0">
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
                        class="form-check-input"
                        {{ $legoSet->interests->contains($interest->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="interest_{{ $interest->id }}">
                        {{ $interest->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="form-group">
        <input type="hidden" name="is_new" value="0">
        <label>
            <input type="checkbox" name="is_new" value="1" {{ $legoSet->is_new ? 'checked' : '' }}> Новинка
        </label>
    </div>

    <div class="form-group">
        <input type="hidden" name="is_sale" value="0">
        <label>
            <input type="checkbox" name="is_sale" value="1" {{ $legoSet->is_sale ? 'checked' : '' }}> На распродаже
        </label>
    </div>

    <div class="form-group">
        <label>Скидка (%)</label>
        <input type="number" name="discount" class="form-control" value="{{ $legoSet->discount }}" min="0" max="100">
    </div>

    <div class="form-group">
        <label>Изображения (добавить новые)</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-success">Сохранить изменения</button>
</form>

@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif
@endsection
