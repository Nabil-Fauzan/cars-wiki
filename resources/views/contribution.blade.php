<x-app-layout>
    @section('meta')
        <title>Contribution Guidelines | PCAR Wiki</title>
        <meta name="description" content="Guidelines for contributing technical data and media to the PCAR Automotive Encyclopedia.">
    @endsection

    <div class="max-w-4xl mx-auto px-margin-page py-stack-lg lg:py-24">
        <div class="mb-16">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tighter text-on-surface mb-4 uppercase italic">
                CONTRIBUTION <span class="text-primary">GUIDELINES</span>
            </h1>
            <p class="text-secondary font-label-caps text-sm tracking-widest">BECOME A DATA ARCHITECT</p>
        </div>

        <div class="space-y-12">
            <section class="glass-card machined-edge p-8 md:p-12 border-primary/20">
                <h2 class="text-2xl font-bold text-on-surface mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">verified</span>
                    Technical Accuracy
                </h2>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed">
                    <p>PCAR is built on verifiable data. When contributing technical specs, please ensure:</p>
                    <ul class="list-disc pl-6 space-y-3 mt-4">
                        <li><strong>OEM Sources Only:</strong> Data should be sourced from manufacturer press kits, technical manuals, or verified track test results.</li>
                        <li><strong>Unit Precision:</strong> Use Metric or Imperial units consistently. Power should be listed as HP (SAE) or PS (Metric) where possible.</li>
                        <li><strong>Multiple Variants:</strong> If a car has multiple engine configurations, list them clearly using the multi-variant input system.</li>
                    </ul>
                </div>
            </section>

            <section class="glass-card p-8 md:p-12 border-outline-variant/20">
                <h2 class="text-2xl font-bold text-on-surface mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">image</span>
                    Media Standards
                </h2>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed">
                    <p>Visual presentation is key to the PCAR aesthetic. All images should follow these protocols:</p>
                    <ul class="list-disc pl-6 space-y-3 mt-4">
                        <li><strong>High Resolution:</strong> Minimum 1920x1080px for Hero images.</li>
                        <li><strong>Clean Composition:</strong> No watermarks, generic dealership branding, or low-quality social media rips.</li>
                        <li><strong>Aspect Ratio:</strong> Prefer 16:9 for the main header to avoid awkward cropping.</li>
                    </ul>
                </div>
            </section>

            <section class="glass-card p-8 md:p-12 border-outline-variant/20">
                <h2 class="text-2xl font-bold text-on-surface mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">history_edu</span>
                    Narrative & History
                </h2>
                <div class="prose prose-invert max-w-none text-secondary leading-relaxed">
                    <p>Beyond numbers, we document the heritage. When writing the "Legacy & Heritage" section:</p>
                    <ul class="list-disc pl-6 space-y-3 mt-4">
                        <li><strong>Objective Tone:</strong> Focus on engineering significance, racing pedigree, and historical impact.</li>
                        <li><strong>Concise & Tactical:</strong> Avoid flowery marketing fluff. Provide information that an enthusiast actually wants to know.</li>
                        <li><strong>No AI Spam:</strong> While AI tools are available for drafting, all final submissions must be human-curated and fact-checked.</li>
                    </ul>
                </div>
            </section>

            <div class="bg-surface-container rounded-xl p-8 border border-primary/10">
                <h3 class="text-xl font-bold text-on-surface mb-4">Submission Workflow</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col gap-2">
                        <span class="text-primary font-bold">Step 1</span>
                        <p class="text-sm text-secondary">Draft your asset in the 'Synchronize Asset' portal.</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="text-primary font-bold">Step 2</span>
                        <p class="text-sm text-secondary">A Data Moderator will audit the technical specs for accuracy.</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="text-primary font-bold">Step 3</span>
                        <p class="text-sm text-secondary">Once verified, the specimen is 'Deployed' to the live wiki.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 text-center">
            <a href="{{ route('dashboard') }}" class="bg-primary text-on-primary px-10 py-4 font-bold rounded hover:brightness-110 transition-all uppercase tracking-widest text-sm inline-block">
                Start Contributing
            </a>
        </div>
    </div>
</x-app-layout>
