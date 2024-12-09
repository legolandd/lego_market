@extends('layouts.app')
@section('title', 'Админ.Заказы')
<head>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
</head>
@section('content')
    <div class="profile-container">
        <aside class="sidebar">
            <h2 class="title">Личный кабинет</h2>
            <ul>
                <li><a href="#" class="text active">Профиль</a></li>
                <li><a href="#" class="text">Мои заказы (1)</a></li>
                <li><a href="#" class="text">Избранное (1)</a></li>
            </ul>
        </aside>

        <section class="profile-content">
            <h2 class="title">Профиль</h2>
            <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                @csrf
                @method('PUT')
                <fieldset>
                    <legend>Личная информация</legend>
                    <div class="input-group">
                        <label for="name" class="text">Имя:</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="input-group">
                        <label for="email" class="text">Email:</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="input-group">
                        <label for="phone" class="text">Телефон:</label>
                        <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}" required>
                    </div>
                    <div class="input-group">
                        <label class="text">Пол:</label>
                            <label>
                                <input type="radio" name="gender" class="text" value="male" {{ auth()->user()->gender == 'male' ? 'checked' : '' }}>
                                Мужской
                            </label>
                            <label>
                                <input type="radio" name="gender" class="text" value="female" {{ auth()->user()->gender == 'female' ? 'checked' : '' }}>
                                Женский
                            </label>
                    </div>
                </fieldset>
                <button type="submit" class="main-button">Сохранить изменения</button>
            </form>
        </section>
    </div>
@endsection
