<section>
    <header>
        <h2 class="font-headline-md text-headline-md text-on-surface">
            Operator Credentials
        </h2>

        <p class="mt-1 font-body-sm text-on-surface-variant">
            Update your account's tactical profile information and primary communication address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">FULL NAME</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required autofocus>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">EMAIL ADDRESS</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">LOCATION</label>
            <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="e.g. Tokyo, JP" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">TACTICAL BIO (MAX 500 CHARS)</label>
            <textarea name="bio" rows="3" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center justify-between p-4 bg-surface-container/30 rounded border border-outline-variant/10">
                <div>
                    <p class="text-xs font-bold text-on-surface uppercase">Public Profile</p>
                    <p class="text-[10px] text-secondary">Allow others to view your garage.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_public" value="0">
                    <input type="checkbox" name="is_public" value="1" class="sr-only peer" {{ old('is_public', $user->is_public) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-surface-container peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-4 bg-surface-container/30 rounded border border-outline-variant/10">
                <div>
                    <p class="text-xs font-bold text-on-surface uppercase">Price Alerts</p>
                    <p class="text-[10px] text-secondary">Notify on market trends.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="price_alerts_enabled" value="0">
                    <input type="checkbox" name="price_alerts_enabled" value="1" class="sr-only peer" {{ old('price_alerts_enabled', $user->price_alerts_enabled) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-surface-container peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
            </div>
        </div>

        <!-- Social Tactical Links -->
        <div class="space-y-4">
            <h3 class="font-label-caps text-label-caps text-secondary">SOCIAL TACTICAL LINKS</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] text-on-surface-variant uppercase font-bold">Instagram URL</label>
                    <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $user->social_links['instagram'] ?? '') }}" placeholder="https://instagram.com/..." class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-2 text-xs">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] text-on-surface-variant uppercase font-bold">Twitter/X URL</label>
                    <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $user->social_links['twitter'] ?? '') }}" placeholder="https://twitter.com/..." class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-2 text-xs">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] text-on-surface-variant uppercase font-bold">YouTube URL</label>
                    <input type="url" name="social_links[youtube]" value="{{ old('social_links.youtube', $user->social_links['youtube'] ?? '') }}" placeholder="https://youtube.com/..." class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-2 text-xs">
                </div>
            </div>
        </div>

        <!-- Top 3 Showcase Selection -->
        <div class="space-y-4">
            <h3 class="font-label-caps text-label-caps text-secondary">THE HOLY TRINITY (TOP 3 SHOWCASE)</h3>
            <p class="text-[10px] text-on-surface-variant -mt-3 italic">Select up to 3 specimens from your garage to showcase on your profile.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @for ($i = 0; $i < 3; $i++)
                    <div class="space-y-1">
                        <label class="text-[10px] text-on-surface-variant uppercase font-bold">Spot #{{ $i + 1 }}</label>
                        <select name="showcase_ids[]" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-2 text-xs">
                            <option value="">-- Empty Spot --</option>
                            @foreach($user->favorites as $car)
                                <option value="{{ $car->model_id }}" {{ (old('showcase_ids.'.$i, $user->showcase_ids[$i] ?? '') == $car->model_id) ? 'selected' : '' }}>
                                    {{ $car->model }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Custom Profile Theme -->
        <div class="space-y-4">
            <h3 class="font-label-caps text-label-caps text-secondary">CUSTOM PROFILE THEME</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] text-on-surface-variant uppercase font-bold">ATMOSPHERE PREFERENCE</label>
                    <select name="profile_theme" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3 text-xs">
                        <option value="default" {{ old('profile_theme', $user->profile_theme) == 'default' ? 'selected' : '' }}>Standard Registry (Dark)</option>
                        <option value="midnight" {{ old('profile_theme', $user->profile_theme) == 'midnight' ? 'selected' : '' }}>Midnight Street (Blue/Neon)</option>
                        <option value="racing-green" {{ old('profile_theme', $user->profile_theme) == 'racing-green' ? 'selected' : '' }}>British Racing Green</option>
                        <option value="stealth" {{ old('profile_theme', $user->profile_theme) == 'stealth' ? 'selected' : '' }}>Stealth Ops (Blackout)</option>
                        <option value="cyberpunk" {{ old('profile_theme', $user->profile_theme) == 'cyberpunk' ? 'selected' : '' }}>Cyberpunk 2077 (Fuchsia/Neon)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-primary text-on-primary px-8 py-3 font-label-caps text-label-caps hover:brightness-110 transition-all">SAVE CHANGES</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="font-body-sm text-primary"
                >Profile updated successfully.</p>
            @endif
        </div>
    </form>
</section>
