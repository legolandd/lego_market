<?php

namespace App\Http\Controllers;

use App\Models\LegoSet;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, LegoSet $legoSet)
    {
        $validated = $request->validate([
            'pros' => 'required|string|max:255',
            'cons' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $review = new Review($validated);
        $review->user_id = auth()->id();
        $review->lego_set_id = $legoSet->id;
        $review->save();

        return redirect()->route('lego_sets.show', $legoSet)->with('success', 'Отзыв добавлен.');
    }
}
