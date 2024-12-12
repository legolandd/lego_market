@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{asset('css/favorites.css')}}">
</head>
@section('content')
        <h1>Избранные товары</h1>
        <div class="favorites-grid">
            @forelse ($favorites as $favorite)
                <a href="{{ route('lego_sets.show', $favorite->lego_set_id) }}">
                <div class="favorite-item">
                    <img src="{{ asset('storage/' . $favorite->legoSet->images->first()->image_url) }}" alt="{{ $favorite->legoSet->name }}">
                    <h3>{{ $favorite->legoSet->name }}</h3>
                    <p>Цена: {{ $favorite->legoSet->price }} ₽</p>
                    <form action="{{ route('favorites.destroy', $favorite->legoSet->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="remove-button">Удалить из избранного</button>
                    </form>
                </div>
                </a>
            @empty
                <p>Список избранного пуст.</p>
            @endforelse
        </div>
@endsection
