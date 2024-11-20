<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interest;
use App\Models\LegoSeries;
use App\Models\LegoSet;
use App\Models\LegoSetInterest;
use Illuminate\Http\Request;

class LegoSetController extends Controller
{
    public function index(){
        $legoSets = LegoSet::all();
        return view ('admin.lego_sets.index', compact('legoSets'));
    }

    public function show(){
        $series = LegoSeries::all();
        $interests = Interest::all();
        return view ('admin.lego_sets.create', compact('series', 'interests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'series_id' => 'required|exists:lego_series,id',
            'price' => 'required|numeric|min:0',
            'recommended_age' => 'required|integer|min:1',
            'piece_count' => 'required|integer|min:1',
            'interests' => 'array|exists:interests,id',
            'is_new' => 'boolean',
            'is_sale' => 'boolean',
            'discount' => 'nullable|integer|between:0,100',
            'images' => 'array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $legoSet = LegoSet::create($validated);

        // Привязываем интересы
        $legoSet->interests()->sync($request->interests);

        // Сохраняем изображения
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $url = $image->store('lego_images');
                $legoSet->images()->create(['image_url' => $url]);
            }
        }

        return redirect()->route('admin.lego_sets.index')->with('success', 'LEGO набор создан.');
    }

    public function edit($id){
        $legoSet = LegoSet::findorfail($id);
        $series = LegoSeries::all();
        $interests = Interest::all();
        return view ('admin.lego_sets.edit', compact('series', 'interests', 'legoSet'));
    }

    public function update(Request $request, LegoSet $legoSet)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'series_id' => 'sometimes|exists:lego_series,id',
            'price' => 'sometimes|numeric|min:0',
            'recommended_age' => 'sometimes|integer|min:1',
            'piece_count' => 'sometimes|integer|min:1',
            'interests' => 'array|exists:interests,id',
            'is_new' => 'boolean',
            'is_sale' => 'boolean',
            'discount' => 'nullable|integer|between:0,100',
            'images' => 'array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $legoSet->update($validated);

        // Обновляем интересы (проверяем, переданы ли интересы в запросе)
        if ($request->has('interests')) {
            $legoSet->interests()->sync($request->interests);
        }

        // Обновляем изображения (если нужно заменить)
        if ($request->has('images')) {
            $legoSet->images()->delete();
            foreach ($request->images as $image) {
                $url = $image->store('lego_images');
                $legoSet->images()->create(['image_path' => $url]);
            }
        }

        return redirect()->route('admin.lego_sets.index')->with('success', 'LEGO набор обновлен.');
    }

    public function destroy(LegoSet $legoSet)
    {
        $legoSet->images()->delete();
        $legoSet->delete();

        return redirect()->route('admin.lego_sets.index')->with('success', 'LEGO набор удален.');
    }
}

