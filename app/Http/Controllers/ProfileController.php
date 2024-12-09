<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Профиль успешно обновлен.');
    }
}
