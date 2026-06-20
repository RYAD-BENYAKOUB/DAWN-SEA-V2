<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->fill($request->validated());
        
        // Handle additional fields that might not be in ProfileUpdateRequest by default
        if ($request->has('first_name')) $user->first_name = $request->first_name;
        if ($request->has('last_name')) {
            $user->last_name = $request->last_name;
            $user->name = $request->first_name . ' ' . $request->last_name;
        }
        if ($request->has('phone')) $user->phone = $request->phone;
        if ($request->has('country_of_birth')) $user->country_of_birth = $request->country_of_birth;
        if ($request->has('birth_date')) $user->birth_date = $request->birth_date;

        if ($request->hasFile('avatar')) {
            $user->avatar = file_get_contents($request->file('avatar')->getRealPath());
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
