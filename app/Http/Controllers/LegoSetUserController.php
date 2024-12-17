<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\LegoSeries;
use App\Models\LegoSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LegoSetUserController extends Controller
{
    // Вынесем общую логику в отдельный метод
    private function applyFiltersAndSorting($query, Request $request)
    {
        // Поиск
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('series', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        } else {
            $query->where('stock', '>', 0);
        }

        // Фильтры
        if ($request->filled('series')) {
            $seriesIds = $request->input('series');
            $query->whereIn('series_id', $seriesIds);
        }

        if ($request->filled('interests')) {
            $interestIds = $request->input('interests');
            $query->whereHas('interests', function ($q) use ($interestIds) {
                $q->whereIn('interests.id', $interestIds);
            });
        }

        if ($request->filled('price')) {
            $priceRange = explode('-', $request->input('price'));
            if (count($priceRange) === 2) {
                $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
            }
        }

        // Сортировка
        if ($request->filled('sort')) {
            $sortOption = $request->input('sort');
            switch ($sortOption) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'expensive':
                    $query->orderBy('price', 'desc');
                    break;
                case 'cheap':
                    $query->orderBy('price', 'asc');
                    break;
                case 'alphabet':
                    $query->orderBy('name', 'asc');
                    break;
            }
        }

        return $query;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $legoSet = LegoSet::query()->with('series');

        // Применяем фильтры и сортировку
        $legoSet = $this->applyFiltersAndSorting($legoSet, $request);

        // Пагинация
        $legoSets = $legoSet->paginate(15, ['*'], 'page', $page);

        $series = LegoSeries::all();
        $interests = Interest::all();

        if ($request->ajax()) {
            // Возвращаем только HTML товаров для AJAX-запросов
            return view('components.lego_sets', ['legoSets' => $legoSets])->render();
        }

        return view('main', compact('legoSets', 'series', 'interests'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1); // Получаем номер страницы из запроса

        $legoSet = LegoSet::query();

        // Применяем фильтры и сортировку
        $legoSet = $this->applyFiltersAndSorting($legoSet, $request);

        // Пагинация с учетом всех фильтров и сортировки
        $legoSets = $legoSet->paginate(10, ['*'], 'page', $page);

        // Генерация HTML для новых наборов
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
