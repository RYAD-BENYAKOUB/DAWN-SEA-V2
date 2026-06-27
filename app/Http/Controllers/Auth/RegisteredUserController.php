<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:50'],
            'country_of_birth' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role' => ['required', 'in:user,guide'],
        ]);

        $avatarData = null;
        if ($request->hasFile('avatar')) {
            $avatarData = file_get_contents($request->file('avatar')->getRealPath());
        }

        $user = new User([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_of_birth' => $request->country_of_birth,
            'birth_date' => $request->birth_date,
            'avatar' => $avatarData,
            'password' => Hash::make($request->password),
        ]);
        $user->role = $request->role;
        $user->save();

        // Auto-create guide profile if role is guide
        if ($request->role === 'guide') {
            $user->guide()->create([]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
