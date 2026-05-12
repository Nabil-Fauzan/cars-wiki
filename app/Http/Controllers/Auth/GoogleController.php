<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $findUser = User::where('google_id', $user->id)
                            ->orWhere('email', $user->email)
                            ->first();

            if ($findUser) {
                // Update google_id and email_verified_at if not set
                $updateData = [
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                ];

                if (!$findUser->email_verified_at) {
                    $updateData['email_verified_at'] = now();
                }

                $findUser->update($updateData);

                // Ensure existing users also have the admin role for testing access
                if (!$findUser->hasRole('admin')) {
                    $findUser->assignRole('admin');
                }
                
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]);

                // Assign admin role for now so you can see the dashboard
                // You can change this to 'user' in production
                $newUser->assignRole('admin');

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }

        } catch (Exception $e) {
            return redirect('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
}
