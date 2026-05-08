<section class="space-y-6">
    <header>
        <h2 class="font-headline-md text-headline-md text-error">
            Decommission Account
        </h2>

        <p class="mt-1 font-body-sm text-on-surface-variant">
            Once your account is decommissioned, all associated tactical data will be permanently purged from the PCAR central database.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-error/20 text-error border border-error/50 px-6 py-2 font-label-caps text-label-caps hover:bg-error hover:text-on-error transition-all"
    >PURGE ACCOUNT</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-headline-sm text-on-surface">
                Confirm Data Purge?
            </h2>

            <p class="mt-1 font-body-sm text-on-surface-variant">
                This action is irreversible. Enter your authorization key to proceed with account decommissioning.
            </p>

            <div class="mt-6">
                <label class="font-label-caps text-label-caps text-secondary mb-2 block">AUTHORIZATION KEY</label>
                <input type="password" name="password" placeholder="Enter key..." class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2 font-label-caps text-label-caps text-secondary hover:text-on-surface">CANCEL</button>
                <button type="submit" class="bg-error text-on-error px-6 py-2 font-label-caps text-label-caps hover:brightness-110 transition-all">CONFIRM PURGE</button>
            </div>
        </form>
    </x-modal>
</section>
