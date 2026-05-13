<x-app-layout>
    @section('meta')
        <title>About PCAR | The Automotive Wiki</title>
        <meta name="description" content="PCAR is the precision-engineered encyclopedia for automotive purists. We document the technical legacy and tactical data of internal combustion masterpieces.">
        <meta property="og:title" content="About PCAR | Automotive Wiki">
        <meta property="og:description" content="Exploring the soul of machinery and documenting automotive excellence.">
    @endsection

    <div class="max-w-6xl mx-auto px-margin-page py-stack-lg lg:py-24">
        <!-- Hero Section -->
        <div class="relative mb-20">
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary/10 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute top-1/2 -right-24 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl opacity-30"></div>
            
            <div class="relative z-10 text-center lg:text-left">
                <h1 class="text-4xl md:text-6xl lg:text-8xl font-extrabold tracking-tighter text-on-surface mb-6 italic">
                    ABOUT <span class="text-primary">PCAR</span>
                </h1>
                <p class="text-lg md:text-xl lg:text-2xl text-secondary max-w-2xl leading-relaxed">
                    The precision-engineered encyclopedia for automotive purists. We don't just list cars; we document the soul of machinery.
                </p>
            </div>
        </div>

        <!-- Mission Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-32">
            <div class="glass-card machined-edge p-10 border-primary/20">
                <div class="w-12 h-12 bg-primary/20 rounded flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                </div>
                <h3 class="text-2xl font-bold text-on-surface mb-4 font-headline-md">Technical Precision</h3>
                <p class="text-secondary leading-relaxed font-body-md">
                    Our database is built on verified technical specifications. From drag coefficients to engine redlines, we prioritize raw data over marketing jargon.
                </p>
            </div>

            <div class="glass-card machined-edge p-10 border-outline-variant/30">
                <div class="w-12 h-12 bg-blue-500/20 rounded flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-blue-400">psychology_alt</span>
                </div>
                <h3 class="text-2xl font-bold text-on-surface mb-4 font-headline-md">Enthusiast Driven</h3>
                <p class="text-secondary leading-relaxed font-body-md">
                    PCAR was born from the need for a unified repository that understands the difference between a daily driver and a masterpiece of engineering.
                </p>
            </div>
        </div>

        <!-- The Vision Section -->
        <div class="relative rounded-2xl overflow-hidden mb-32 group">
            <img src="https://images.unsplash.com/photo-1542362567-b052cb1341f1?auto=format&fit=crop&q=80&w=2000" 
                 class="w-full h-[500px] object-cover opacity-40 grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 cursor-pointer" 
                 alt="Automotive Heritage">
            <div class="absolute inset-0 bg-gradient-to-t from-background via-background/40 to-transparent flex items-end p-8 md:p-12">
                <div class="max-w-3xl">
                    <h2 class="text-3xl lg:text-5xl font-bold text-on-surface mb-6 tracking-tight">DOCUMENTING AUTOMOTIVE EXCELLENCE</h2>
                    <p class="text-lg text-secondary/90 leading-relaxed italic">
                        "In an era of electrification and automation, we believe in preserving the technical legacy of internal combustion and the pure tactile feedback of driving."
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-32">
            <div class="text-center p-8 bg-surface-container/30 rounded-xl border border-outline-variant/10 hover:border-primary/50 transition-all duration-300 hover:-translate-y-2 group">
                <p class="text-4xl font-black text-primary mb-1 group-hover:scale-110 transition-transform">{{ $carCount }}+</p>
                <p class="text-[10px] font-label-caps text-secondary uppercase tracking-widest">Specimens Logged</p>
            </div>
            <div class="text-center p-8 bg-surface-container/30 rounded-xl border border-outline-variant/10 hover:border-primary/50 transition-all duration-300 hover:-translate-y-2 group">
                <p class="text-4xl font-black text-on-surface mb-1 group-hover:text-primary transition-colors">100%</p>
                <p class="text-[10px] font-label-caps text-secondary uppercase tracking-widest">Open Access</p>
            </div>
            <div class="text-center p-8 bg-surface-container/30 rounded-xl border border-outline-variant/10 hover:border-primary/50 transition-all duration-300 hover:-translate-y-2 group">
                <p class="text-4xl font-black text-on-surface mb-1 group-hover:text-primary transition-colors">24/7</p>
                <p class="text-[10px] font-label-caps text-secondary uppercase tracking-widest">Live Updates</p>
            </div>
            <div class="text-center p-8 bg-surface-container/30 rounded-xl border border-outline-variant/10 hover:border-primary/50 transition-all duration-300 hover:-translate-y-2 group">
                <p class="text-4xl font-black text-on-surface mb-1 group-hover:text-primary transition-colors">∞</p>
                <p class="text-[10px] font-label-caps text-secondary uppercase tracking-widest">Passion Infused</p>
            </div>
        </div>

        <!-- Contact/Footer -->
        <div class="text-center">
            <h4 class="text-secondary font-label-caps text-sm mb-8 tracking-[0.3em]">WANT TO CONTRIBUTE?</h4>
            <a href="mailto:contact@pcar.wiki" 
               class="inline-flex items-center gap-4 bg-surface-container-highest border border-primary/30 px-10 py-5 rounded-full text-on-surface hover:bg-primary/20 hover:border-primary transition-all active:scale-95 group">
                <span class="font-bold tracking-widest text-sm uppercase">Secure Transmission</span>
                <span class="material-symbols-outlined text-primary group-hover:translate-x-2 transition-transform">send</span>
            </a>
        </div>
    </div>
</x-app-layout>
