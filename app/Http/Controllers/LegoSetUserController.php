<?php

namespace App\Http\Controllers;

use App\Models\LegoSet;
use Illuminate\Http\Request;

class LegoSetUserController extends Controller
{
    // Просмотр и фильтрация наборов
    public function index(Request $request)
    {
        $legoSet = LegoSet::query();

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

        return view('lego_sets.index', compact('legoSets'));
    }

    public function show($id)
    {
        $legoSet = LegoSet::findorfail($id);
        $images = $legoSet->images;
        $reviews = $legoSet->reviews()->with('user')->get();

        return view('lego_sets.show', compact('legoSet', 'images', 'reviews'));
    }
}
