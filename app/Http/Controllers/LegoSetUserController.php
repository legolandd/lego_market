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

        // Поиск
        if ($request->filled('search')) {
            $search = $request->input('search');
            $legoSet->where('name', 'like', "%$search%")
                ->orWhereHas('series', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        } else {
            $legoSet->where('stock', '>', 0);
        }

        // Фильтры
        if ($request->filled('series')) {
            $seriesIds = $request->input('series');
            $legoSet->whereIn('series_id', $seriesIds);
        }

        if ($request->filled('interests')) {
            $interestIds = $request->input('interests');
            $legoSet->whereHas('interests', function ($query) use ($interestIds) {
                $query->whereIn('interests.id', $interestIds);
            });
        }

        if ($request->filled('price')) {
            $priceRange = explode('-', $request->input('price'));
            if (count($priceRange) === 2) {
                $legoSet->whereBetween('price', [$priceRange[0], $priceRange[1]]);
            }
        }

        // Пагинация
        $legoSets = $legoSet->paginate(15);

        if ($request->ajax()) {
            $legoSets = $legoSet->paginate(100);
            // Возвращаем только HTML товаров для AJAX-запросов
            return view('components.lego_sets', ['legoSets' => $legoSets])->render();
        }

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
