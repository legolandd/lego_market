<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\LegoSet;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addToFavorites(LegoSet $legoSet)
    {
        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'lego_set_id' => $legoSet->id,
        ]);

        return redirect()->back()->with('success', 'Набор добавлен в избранное.');
    }
}
