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
<div class="container">
    <h1>LEGO Наборы</h1>

    <!-- Форма фильтрации -->
    <form action="{{ route('lego_sets.index') }}" method="GET">
        <div class="row">
            <div>
                <label for="min_price">Цена от:</label>
                <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
            </div>
            <div>
                <label for="max_price">Цена до:</label>
                <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
            </div>
            <div>
                <label for="is_new">Новинка:</label>
                <select name="is_new" id="is_new" class="form-control">
                    <option value="">Все</option>
                    <option value="1" {{ request('is_new') == '1' ? 'selected' : '' }}>Да</option>
                    <option value="0" {{ request('is_new') == '0' ? 'selected' : '' }}>Нет</option>
                </select>
            </div>
            <div>
                <label for="sort_by">Сортировка:</label>
                <select name="sort_by" id="sort_by" class="form-control">
                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Цена</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Новинки</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Применить</button>
            </div>
        </div>
    </form>

    <!-- Список наборов -->
    <div class="row">
        @foreach($legoSets as $legoSet)
            <div>
                <div>
                    @if ($legoSet->images->isNotEmpty())
                        <img src="{{ $legoSet->images->first()->image_url }}" class="card-img-top" alt="{{ $legoSet->name }}">
                    @else
                        <img src="default.jpg" class="card-img-top" alt="Default image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $legoSet->name }}</h5>
                        <p class="card-text">Цена: {{ $legoSet->price }} ₽</p>
                        <a href="{{ route('lego_sets.show', $legoSet->id) }}" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div>
        {{ $legoSets->links() }}
    </div>
</div>

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
