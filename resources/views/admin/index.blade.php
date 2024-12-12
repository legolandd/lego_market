@extends('layouts.app')
@section('title', 'Админ-панель')
<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
@section('content')
    <div class="wrapper">
        <a href="{{route('admin.lego_sets.index')}}" class="admin-card">
            <p>Лего-наборы</p>
        </a>
        <a href="{{route('admin.lego_series.index')}}" class="admin-card">
            <p>Лего-серии</p>
        </a>
        <a href="{{route('admin.orders.index')}}" class="admin-card">
            <p>Заказы</p>
        </a>
    </div>
@endsection
