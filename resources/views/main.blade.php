<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Лего</title>
</head>
<body>
<h1>Добро пожаловать</h1>

<a href="{{route('admin.lego_sets.index')}}">Лего-наборы (админ)</a>
<a href="/lego_sets">Лего-наборы (пользователь)</a>

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

<a href="/logout">Выйти</a>
</body>
</html>
