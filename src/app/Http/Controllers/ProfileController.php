<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use Illuminate\Http\Request;
class ProfileController extends Controller
{

    public function show(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'sell');
        if ($tab === 'buy') {
            $items = Item::whereHas('purchases', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $items = Item::where('user_id', $user->id)->get();
        }
        return view('profile.mypage', compact('user', 'items', 'tab'));
    }


    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $path;
        }
        $user->update($validated);
        return redirect('/mypage');
    }
}

