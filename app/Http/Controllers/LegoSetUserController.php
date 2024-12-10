<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\LegoSeries;
use App\Models\LegoSet;
use Illuminate\Http\Request;

class LegoSetUserController extends Controller
{
    public function index(Request $request)
    {
        $legoSet = LegoSet::query();

        // Поиск по названию набора и серии
        if ($request->filled('search')) {
            $search = $request->input('search');
            $legoSet->where('name', 'like', "%$search%")
                ->orWhereHas('series', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        } else {
            // Скрывать товары с нулевым количеством на складе, если это не поиск
            $legoSet->where('stock', '>', 0);
        }

        // Фильтрация по цене
        if ($request->has('min_price') && $request->has('max_price')) {
            $legoSet->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Фильтрация по новинкам
        if ($request->has('is_new')) {
            $legoSet->where('is_new', $request->is_new);
        }

        // Сортировка
        if ($request->has('sort_by')) {
            $sortBy = $request->sort_by;
            $sortOrder = $request->sort_order ?? 'asc';
            $legoSet->orderBy($sortBy, $sortOrder);
        }

        $legoSets = $legoSet->paginate(10);
        $series = LegoSeries::all();
        $interests = Interest::all();

        return view('main', compact('legoSets', 'series', 'interests'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1); // Получаем номер страницы из запроса
        $legoSets = LegoSet::paginate(10, ['*'], 'page', $page);

        // Генерируем HTML для новых наборов
        $html = view('components.lego_sets', ['legoSets' => $legoSets])->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $legoSets->hasMorePages(), // Проверяем, есть ли еще страницы
        ]);
    }

    public function show($id)
    {
        $legoSet = LegoSet::findorfail($id);
        $images = $legoSet->images;
        $reviews = $legoSet->reviews()->with('user')->get();

        return view('lego_sets.show', compact('legoSet', 'images', 'reviews'));
    }
}
