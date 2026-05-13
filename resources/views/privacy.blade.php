<x-app-layout>
    @section('meta')
        <title>Privacy Policy | PCAR Wiki</title>
        <meta name="description" content="Privacy Policy and Data Protection protocols for the PCAR Automotive Wiki.">
    @endsection

    <div class="max-w-4xl mx-auto px-margin-page py-stack-lg lg:py-24">
        <div class="mb-16">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tighter text-on-surface mb-4 uppercase italic">
                PRIVACY <span class="text-primary">POLICY</span>
            </h1>
            <p class="text-secondary font-label-caps text-sm tracking-widest">LAST UPDATED: MAY 2026</p>
        </div>

        <div class="space-y-12">
            <section class="glass-card p-8 md:p-12 border-outline-variant/20">
                <div class="flex items-center gap-4 mb-6">
                    <span class="w-8 h-8 bg-primary/20 rounded flex items-center justify-center text-primary font-bold">01</span>
                    <h2 class="text-2xl font-bold text-on-surface font-headline-md uppercase">Data Collection</h2>
                </div>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed space-y-4">
                    <p>PCAR collects minimal data to provide a personalized automotive encyclopedia experience. This includes:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Account Information:</strong> Google OAuth data (name, email, profile picture) for authentication.</li>
                        <li><strong>Technical Logs:</strong> Anonymous data regarding comparison sets and vehicle views for our heatmap analytics.</li>
                        <li><strong>Personal Garage:</strong> Vehicles you favorite or add personal notes to are stored securely in your private profile.</li>
                    </ul>
                </div>
            </section>

            <section class="glass-card p-8 md:p-12 border-outline-variant/20">
                <div class="flex items-center gap-4 mb-6">
                    <span class="w-8 h-8 bg-primary/20 rounded flex items-center justify-center text-primary font-bold">02</span>
                    <h2 class="text-2xl font-bold text-on-surface font-headline-md uppercase">Usage Protocols</h2>
                </div>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed space-y-4">
                    <p>We use your data strictly for the following technical objectives:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Synchronizing your cross-device automotive "Garage".</li>
                        <li>Improving the precision of our Technical Comparison Engine.</li>
                        <li>Maintaining the integrity of our community-driven specifications.</li>
                    </ul>
                    <p class="text-primary font-bold italic">We never sell, distribute, or leak your tactical data to third-party advertisers.</p>
                </div>
            </section>

            <section class="glass-card p-8 md:p-12 border-outline-variant/20">
                <div class="flex items-center gap-4 mb-6">
                    <span class="w-8 h-8 bg-primary/20 rounded flex items-center justify-center text-primary font-bold">03</span>
                    <h2 class="text-2xl font-bold text-on-surface font-headline-md uppercase">Encryption & Security</h2>
                </div>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed space-y-4">
                    <p>All data transmissions are handled via encrypted protocols. Your automotive identity is protected by industry-standard OAuth security provided by Google.</p>
                </div>
            </section>

            <section class="glass-card p-8 md:p-12 border-outline-variant/20">
                <div class="flex items-center gap-4 mb-6">
                    <span class="w-8 h-8 bg-primary/20 rounded flex items-center justify-center text-primary font-bold">04</span>
                    <h2 class="text-2xl font-bold text-on-surface font-headline-md uppercase">Data Sovereignty</h2>
                </div>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed space-y-4">
                    <p>You maintain full sovereignty over your data. At any time, you can:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Wipe your personal comparison history.</li>
                        <li>Clear your saved "Garage" specimens.</li>
                        <li>Request full deletion of your identity from the PCAR registry.</li>
                    </ul>
                </div>
            </section>
        </div>

        <div class="mt-20 p-8 border-t border-outline-variant/20 text-center">
            <p class="text-secondary text-sm mb-6">Questions regarding our tactical data handling?</p>
            <a href="mailto:privacy@pcar.wiki" class="text-primary font-label-caps text-label-caps hover:underline">CONTACT DATA OFFICER</a>
        </div>
    </div>
</x-app-layout>
