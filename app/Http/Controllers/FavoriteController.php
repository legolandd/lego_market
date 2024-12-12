<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\LegoSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Метод для добавления товара в избранное
    public function store(Request $request, $legoSetId)
    {
        $user = Auth::user();

        // Проверяем, есть ли уже товар в избранном
        if (Favorite::where('user_id', $user->id)->where('lego_set_id', $legoSetId)->exists()) {
            return redirect()->back()->with('error', 'Этот товар уже добавлен в избранное');
        }

        Favorite::create([
            'user_id' => $user->id,
            'lego_set_id' => $legoSetId,
        ]);

        return redirect()->back()->with('success', 'Набор добавлен в избранное.');
    }

    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->with('legoSet')->get();

        return view('favorites.index', compact('favorites'));
    }

    public function destroy($legoSetId)
    {
        $user = Auth::user();

        Favorite::where('user_id', $user->id)->where('lego_set_id', $legoSetId)->delete();

        return redirect()->back()->with('success', 'Набор удалён из избранного.');
    }
}
