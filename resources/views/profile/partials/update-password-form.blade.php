<section>
    <header>
        <h2 class="font-headline-md text-headline-md text-on-surface">
            Security Uplink
        </h2>

        <p class="mt-1 font-body-sm text-on-surface-variant">
            Ensure your tactical access remains secure by rotating your authorization key.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">CURRENT ACCESS KEY</label>
            <input type="password" name="current_password" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">NEW ACCESS KEY</label>
            <input type="password" name="password" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <label class="font-label-caps text-label-caps text-secondary">CONFIRM NEW KEY</label>
            <input type="password" name="password_confirmation" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-primary text-on-primary px-8 py-3 font-label-caps text-label-caps hover:brightness-110 transition-all">ROTATE KEY</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="font-body-sm text-primary"
                >Access key successfully rotated.</p>
            @endif
        </div>
    </form>
</section>
