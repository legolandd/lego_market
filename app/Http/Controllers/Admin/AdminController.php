<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegoSeries;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function indexSeries(){
        $series = LegoSeries::all();
        return view('admin.lego_series.index', compact('series'));
    }

    public function storeSeries(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lego_series',
        ],
            [
                'name.required' => 'Название серии обязательно для заполнения.',
                'name.max' => 'Название серии превышает 255 символов.',
                'name.unique' => 'Серия с таким названием уже существует.',
            ]);

        LegoSeries::create($validated);

        return redirect()->route('admin.lego_series.index')->with('success', 'Серия успешно добавлена!');
    }
}
