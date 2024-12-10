@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h1 class="title">Каталог конструкторов лего</h1>

    <p><a href="{{route('admin.lego_sets.index')}}">Лего-наборы (админ)</a></p>
    <p><a href="{{route('admin.dashboard')}}">Админ панель</a></p>

    <p><a href="/logout">Выйти</a></p>
    <div class="catalog-container">
        <aside class="filters">
            <h3>Фильтры</h3>
            <form method="GET" action="{{ route('lego_sets.index') }}">
                <!-- Серия -->
                <div class="filter-section">
                    <h4>Серия</h4>
                    @foreach($series as $serie)
                        <label>
                            <input type="checkbox" name="series[]" value="{{ $serie->id }}"
                                {{ in_array($serie->id, request('series', [])) ? 'checked' : '' }}>
                            {{ $serie->name }}
                        </label>
                    @endforeach
                </div>

                <!-- Интересы -->
                <div class="filter-section">
                    <h4>Интересы</h4>
                    @foreach($interests as $interest)
                        <label>
                            <input type="checkbox" name="interests[]" value="{{ $interest->id }}"
                                {{ in_array($interest->id, request('interests', [])) ? 'checked' : '' }}>
                            {{ $interest->name }}
                        </label>
                    @endforeach
                </div>

                <!-- Цена -->
                <div class="filter-section">
                    <h4>Цена</h4>
                    <label>
                        <input type="radio" name="price" value="0-1500" {{ request('price') == '0-1500' ? 'checked' : '' }}>
                        до 1500 ₽
                    </label>
                    <label>
                        <input type="radio" name="price" value="1500-3000" {{ request('price') == '1500-3000' ? 'checked' : '' }}>
                        1500-3000 ₽
                    </label>
                    <!-- Добавьте остальные диапазоны -->
                </div>

                <button type="submit" class="main-button">Применить</button>
            </form>
        </aside>
        @if ($legoSets->isEmpty())
            <p>По запросу "{{ request('search') }}" ничего не найдено.</p>
        @else
            <main class="catalog">
                <div class="catalog-grid" id="lego-sets-container">
                    @include('components.lego_sets', ['legoSets' => $legoSets])
                </div>
                <div id="loading-indicator" class="loading-indicator hidden">
                    <div class="loader"></div>
                </div>
                <div id="pagination-placeholder"></div>
            </main>
            <script src="{{ asset('js/page-loader.js') }}"></script>
    </div>
    @endif
@endsection
