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
