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
<h1>LEGO Наборы</h1>
<a href="{{ route('admin.lego_sets.create') }}" class="btn btn-primary">Создать новый набор</a>

<table class="table mt-3">
    <thead>
    <tr>
        <th>Название</th>
        <th>Серия</th>
        <th>Цена</th>
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

@if (session())
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if (session())
    <div class="alert alert-success">
        {{session('error')}}
    </div>
@endif
</body>
</html>
