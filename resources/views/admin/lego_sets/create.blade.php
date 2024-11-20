<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Админ</title>
</head>
<body>
<h1>Создать новый LEGO набор</h1>

<form action="{{ route('admin.lego_sets.store') }}" method="POST" enctype="multipart/form-data">
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
        <input type="number" name="price" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Рекомендуемый возраст</label>
        <input type="number" name="recommended_age" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Количество деталей</label>
        <input type="number" name="piece_count" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Интересы</label>
        <select name="interests[]" class="form-control" multiple>
            @foreach ($interests as $interest)
                <option value="{{ $interest->id }}">{{ $interest->name }}</option>
            @endforeach
        </select>
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
</body>
