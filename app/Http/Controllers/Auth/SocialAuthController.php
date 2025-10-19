<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Danyseifeddine\Keychain\Http\Controllers\SocialAuthController as BaseSocialAuthController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends BaseSocialAuthController
{
    /**
     * Completely override the authentication callback
     * Return null to use KeyChain's default flow
     */
    public function handleCustomCallback(string $provider): ?\Illuminate\Http\RedirectResponse
    {
        // Your completely custom authentication logic
        $socialiteUser = Socialite::driver($provider)->user();

        // Custom user creation/retrieval logic
        $user = $this->myCustomUserLogic($socialiteUser, $provider);

        // Custom token storage
        $this->storeToken($provider, $socialiteUser, 'web');

        // Custom login
        Auth::login($user);

        // Custom redirect
        return redirect()->route('super-admin.dashboard')
            ->with('success', "Welcome! You've been authenticated via {$provider}");
    }

    private function myCustomUserLogic($socialiteUser, $provider)
    {
        // Your custom logic here...
        return User::firstOrCreate(
            ['email' => $socialiteUser->getEmail()],
            [
                'name' => $socialiteUser->getName(),
                'password' => bcrypt(str()->random(16)),
                'email_verified_at' => now(),
                'provider' => $provider,
                'custom_field' => 'custom_value',
            ]
        )->assignRole('user');
    }
}
