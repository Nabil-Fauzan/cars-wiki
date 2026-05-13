<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     */
    public function show(User $user): View
    {
        if (!$user->is_public && Auth::id() !== $user->id) {
            abort(403, 'This tactical profile is private.');
        }

        return view('profile.show', [
            'user' => $user,
        ]);
    }

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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

    /**
     * Follow a user.
     */
    public function follow(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) return back();
        
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        $authUser->following()->syncWithoutDetaching([$user->id]);
        
        return back()->with('success', "Strategic Alliance established with {$user->name}.");
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user): RedirectResponse
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        $authUser->following()->detach($user->id);
        
        return back()->with('success', "Strategic Alliance with {$user->name} terminated.");
    }
}
