<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $incidents = Incident::all();

        return Inertia::render('Auth/Register', [
            'incidents' => Incident::all()->map(function ($incident) {
                return [
                    'value' => $incident->id,
                    'label' => $incident->name
                ];
            }),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-90,90',
            'incidents' => 'required|array|min:1|max:3',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'password' => Hash::make($request->password),
        ]);

        foreach ($request->incidents as $incident) {
            $incident = $incident;
            $user->incidents()->attach($incident);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
