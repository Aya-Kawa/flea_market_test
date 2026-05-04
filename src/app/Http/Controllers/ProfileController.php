<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load(['purchases.item']);
        return view('profile.mypage', compact('user'));
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
        return redirect('/');
    }
}

