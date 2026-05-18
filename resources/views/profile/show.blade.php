<x-app-layout>
    @section('meta')
        <title>{{ $user->name }}'s Tactical Profile | PCAR</title>
        <meta name="robots" content="{{ $user->is_public ? 'index, follow' : 'noindex, nofollow' }}">
    @endsection

    <div class="min-h-screen {{ $user->theme_classes }}">
    <div class="max-w-6xl mx-auto px-margin-page py-stack-lg lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter items-start">
            
            <!-- Left Column: Identity Card -->
            <div class="lg:col-span-1 space-y-gutter">
                <div class="glass-card machined-edge p-8 rounded-2xl text-center relative overflow-hidden group">
                    <!-- Dynamic Brand Banner -->
                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r {{ $user->brand_theme }} opacity-30 group-hover:opacity-50 transition-opacity duration-1000"></div>
                    
                    <div class="relative z-10 mb-6">
                        <div class="relative inline-block">
                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}" 
                                 class="w-32 h-32 rounded-full border-4 border-primary/20 shadow-2xl object-cover relative z-10 {{ $user->avatar_frame }}">
                            <!-- Reputation Badge -->
                            @if($user->reputation_score > 0)
                                <div class="absolute -right-2 -bottom-2 bg-yellow-500 text-black p-1.5 rounded-full z-20 shadow-lg border-2 border-background flex items-center justify-center group/rep" title="Reputation Score: {{ $user->reputation_score }}">
                                    <span class="material-symbols-outlined text-sm font-bold">verified</span>
                                    <span class="absolute left-full ml-2 px-2 py-1 bg-black text-white text-[10px] rounded opacity-0 group-hover/rep:opacity-100 transition-opacity whitespace-nowrap">{{ $user->reputation_score }} Rep</span>
                                </div>
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-1/2 translate-x-16 bg-primary text-on-primary text-[10px] font-bold px-2 py-1 rounded-full border-2 border-background z-30 shadow-lg">
                            {{ strtoupper($user->rank) }}
                        </div>
                    </div>

                    <h2 class="text-3xl font-extrabold tracking-tighter italic uppercase mb-1 relative z-10">{{ $user->name }}</h2>
                    
                    <!-- Strategic Alliances (Followers) -->
                    <div class="flex justify-center gap-6 mb-6 relative z-10">
                        <div class="text-center">
                            <p class="text-sm font-black text-on-surface">{{ $user->followers()->count() }}</p>
                            <p class="text-[8px] text-secondary font-bold uppercase tracking-widest">Followers</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-black text-on-surface">{{ $user->following()->count() }}</p>
                            <p class="text-[8px] text-secondary font-bold uppercase tracking-widest">Following</p>
                        </div>
                    </div>

                    <!-- Follow Button -->
                    @if(Auth::check() && Auth::id() !== $user->id)
                        <div class="mb-6 relative z-10">
                            @if(Auth::user()->isFollowing($user))
                                <form action="{{ route('profile.unfollow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-surface-container border border-outline-variant text-[10px] font-bold uppercase tracking-widest rounded-lg hover:bg-error/10 hover:text-error transition-all">Terminate Alliance</button>
                                </form>
                            @else
                                <form action="{{ route('profile.follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-primary text-on-primary text-[10px] font-bold uppercase tracking-widest rounded-lg shadow-lg shadow-primary/20 hover:brightness-110 transition-all">Establish Alliance</button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <!-- Specialist Tags -->
                    <div class="flex flex-wrap justify-center gap-2 mb-4 relative z-10">
                        @foreach($user->specialist_tags as $tag)
                            <span class="text-[8px] font-bold px-2 py-0.5 bg-primary/10 border border-primary/20 text-primary rounded-full uppercase tracking-widest">{{ $tag }}</span>
                        @endforeach
                    </div>

                    <p class="text-secondary text-sm font-label-caps tracking-widest mb-6 relative z-10">{{ $user->location ?? 'Global Registry' }}</p>
                    
                    <div class="p-4 bg-surface-container/50 rounded-xl border border-outline-variant/10 text-left mb-6 relative z-10">
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            {{ $user->bio ?? 'No tactical bio provided. This operator prefers silence.' }}
                        </p>
                    </div>

                    <!-- Social Tactical Links -->
                    <div class="flex justify-center gap-4 mb-6 relative z-10">
                        @foreach($user->social_links ?? [] as $platform => $url)
                            <a href="{{ $url }}" target="_blank" class="w-8 h-8 rounded-lg bg-surface-container-highest border border-outline-variant/30 flex items-center justify-center hover:border-primary transition-all text-secondary hover:text-primary">
                                <span class="material-symbols-outlined text-sm">
                                    {{ match($platform) { 'instagram' => 'photo_camera', 'twitter' => 'share', 'youtube' => 'smart_display', default => 'link' } }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <div class="flex justify-center gap-4 relative z-10">
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="px-6 py-2 bg-surface-container-highest border border-outline-variant text-on-surface text-xs font-bold uppercase rounded hover:bg-white/5 transition-all">Edit Credentials</a>
                        @endif
                    </div>
                </div>

                <!-- Personal Garage Stats -->
                <div class="glass-card p-6 rounded-2xl border-primary/5">
                    <h3 class="font-label-caps text-label-caps text-primary mb-6 tracking-[0.2em]">GARAGE ANALYTICS</h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-gradient-to-br from-primary/10 to-transparent rounded-xl border border-primary/5 mb-2">
                            <p class="text-[10px] text-primary font-bold uppercase tracking-widest mb-1">ESTIMATED ASSET VALUE</p>
                            <p class="text-2xl font-black text-on-surface">${{ number_format($user->garage_stats['total_value'] / 1000, 1) }}k</p>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-surface-container/30 rounded-lg">
                            <span class="text-xs text-secondary font-bold uppercase">TOTAL PERFORMANCE</span>
                            <span class="text-sm font-black text-on-surface">{{ number_format($user->garage_stats['total_hp']) }} HP</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-surface-container/30 rounded-lg border-l-2 border-primary">
                            <span class="text-xs text-secondary font-bold uppercase">BRAND SPECIALTY</span>
                            <span class="text-sm font-black text-primary">{{ $user->garage_stats['fav_brand'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-surface-container/30 rounded-lg">
                            <span class="text-xs text-secondary font-bold uppercase">ERA PREFERENCE</span>
                            <span class="text-sm font-black text-on-surface">{{ $user->garage_stats['era'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Activity & Showcase -->
            <div class="lg:col-span-2 space-y-gutter">
                <!-- Top 3 Showcase -->
                @php $showcaseCars = \App\Models\Car::whereIn('model_id', $user->showcase_ids ?? [])->get(); @endphp
                @if($showcaseCars->count() > 0)
                <div class="glass-card machined-edge p-8 rounded-2xl border-yellow-500/10">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-yellow-500">military_tech</span>
                        <h3 class="font-label-caps text-label-caps text-yellow-500 tracking-[0.2em]">THE HOLY TRINITY (SHOWCASE)</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($showcaseCars as $car)
                            <a href="{{ route('cars.show', $car) }}" class="flex flex-col gap-3 group">
                                <div class="relative overflow-hidden rounded-xl aspect-[4/3] border border-outline-variant/30 group-hover:border-yellow-500 transition-all">
                                    <img src="{{ $car->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="absolute bottom-3 left-3 right-3">
                                        <p class="text-[10px] font-black text-white uppercase truncate">{{ $car->model }}</p>
                                        <p class="text-[8px] text-yellow-500 font-bold uppercase tracking-widest">{{ $car->brands->first()->name ?? '' }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Contribution Heatmap -->
                <div class="glass-card machined-edge p-8 rounded-2xl">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="font-label-caps text-label-caps text-primary tracking-[0.2em]">CONTRIBUTION HEATMAP</h3>
                        <span class="text-[10px] text-secondary">LAST 30 DAYS</span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->contribution_heatmap as $date => $count)
                            <div class="w-8 h-8 rounded-sm transition-all cursor-help relative group"
                                 style="background-color: {{ $count > 5 ? '#ff4d4d' : ($count > 2 ? '#ff9999' : ($count > 0 ? '#ffcccc' : 'rgba(255,255,255,0.05)')) }}">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-black text-[10px] text-white rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity z-50">
                                    {{ $date }}: {{ $count }} logs
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-2 text-[8px] text-secondary uppercase font-bold">
                        <span>Low Activity</span>
                        <div class="w-3 h-3 rounded-sm bg-white/5"></div>
                        <div class="w-3 h-3 rounded-sm bg-[#ffcccc]"></div>
                        <div class="w-3 h-3 rounded-sm bg-[#ff9999]"></div>
                        <div class="w-3 h-3 rounded-sm bg-[#ff4d4d]"></div>
                        <span>Peak Performance</span>
                    </div>
                </div>

                <!-- Recent Garage Additions -->
                <div class="glass-card p-8 rounded-2xl">
                    <h3 class="font-label-caps text-label-caps text-on-surface-variant mb-8 tracking-[0.2em]">RECENT GARAGE ADDITIONS</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($user->favorites()->latest()->take(4)->get() as $car)
                            <a href="{{ route('cars.show', $car) }}" class="flex items-center gap-4 p-3 bg-surface-container/30 rounded-xl hover:bg-white/5 transition-all group">
                                <img src="{{ $car->image_url }}" class="w-20 h-14 object-cover rounded-lg border border-outline-variant/20 group-hover:border-primary/50">
                                <div class="overflow-hidden">
                                    <p class="text-xs font-bold text-on-surface truncate uppercase tracking-tighter">{{ $car->model }}</p>
                                    <p class="text-[10px] text-secondary uppercase tracking-widest">{{ $car->category }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full py-12 text-center text-on-surface-variant/40 border-2 border-dashed border-outline-variant/10 rounded-2xl italic text-sm">
                                This garage is currently empty. Start scouting specimens.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Comparison Sets -->
                @if(Auth::id() === $user->id)
                <div class="glass-card p-8 rounded-2xl">
                    <h3 class="font-label-caps text-label-caps text-on-surface-variant mb-8 tracking-[0.2em]">SAVED BATTLE LOGS</h3>
                    <div class="space-y-3">
                        @forelse($user->comparisonSets()->latest()->take(5)->get() as $set)
                            <div class="flex justify-between items-center p-4 bg-surface-container/20 rounded-xl border border-outline-variant/5">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">swords</span>
                                    <span class="text-xs font-bold text-on-surface uppercase">{{ $set->name }}</span>
                                </div>
                                <a href="{{ route('compare', ['car1' => $set->car1_id, 'car2' => $set->car2_id, 'car3' => $set->car3_id]) }}" class="text-[10px] font-bold text-primary hover:underline">RE-ENGAGE BATTLE</a>
                            </div>
                        @empty
                             <p class="text-center text-on-surface-variant/40 italic text-xs py-4">No battles recorded in history.</p>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
