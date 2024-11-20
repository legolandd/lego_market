<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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
        <label>Интересы</label>
        <select name="interests[]" class="form-control" multiple>
            @foreach ($interests as $interest)
                <option value="{{ $interest->id }}" {{ $legoSet->interests->contains($interest->id) ? 'selected' : '' }}>{{ $interest->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Новинка</label>
        <input type="checkbox" name="is_new" value="1" {{ $legoSet->is_new ? 'checked' : '' }}>
    </div>

    <div class="form-group">
        <label>На распродаже</label>
        <input type="checkbox" name="is_sale" value="1" {{ $legoSet->is_sale ? 'checked' : '' }}>
    </div>

    <div class="form-group">
        <label>Скидка (%)</label>
        <input type="number" name="discount" class="form-control" value="{{ $legoSet->discount }}" min="0" max="100">
    </div>

    <div class="form-group">
        <label>Изображения (добавить новые)</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>

@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif
</body>
</html>
