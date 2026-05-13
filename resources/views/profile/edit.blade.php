<x-app-layout>

    <div class="max-w-4xl mx-auto px-margin-page py-stack-lg">
        <div class="mb-stack-md flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface uppercase tracking-tighter">Authorized Operator Profile</h1>
                <p class="text-on-surface-variant font-body-lg">Modify your credentials and tactical access parameters.</p>
            </div>
            <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center gap-2 px-6 py-3 bg-primary/20 border border-primary/30 text-primary font-bold text-xs uppercase rounded hover:bg-primary/30 transition-all">
                <span class="material-symbols-outlined text-sm">visibility</span>
                View Tactical Profile
            </a>
        </div>

        <div class="space-y-gutter">
            <div class="glass-card machined-edge p-stack-md rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="glass-card machined-edge p-stack-md rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="glass-card machined-edge p-stack-md rounded-lg border-t-4 border-t-error/30">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
