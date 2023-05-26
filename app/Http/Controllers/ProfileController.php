<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        Auth::user()->load('incidents');

        return Inertia::render('Profile/Edit', [
            'status' => session('status'),
            'incidents' => Incident::all()->map(function ($incident) {
                return [
                    'value' => $incident->id,
                    'label' => $incident->name
                ];
            }),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $request->user()->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $request->user()->id . '|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-90,90',
            'incidents' => 'required|array|min:1|max:3',
        ]);

        if($request->has('incidents')) {
            $incidents = $request->input('incidents');
            $user = $request->user();
            $user->incidents()->sync($incidents);
        }

        $request->user()->forceFill([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ])->save();

        return Redirect::back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
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
