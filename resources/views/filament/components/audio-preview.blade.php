@php
    $state = $getState();
@endphp

@if($state)
    <div class="flex items-center gap-2 py-1" x-data="{ playing: false, audio: null }" x-init="$watch('playing', value => { if (!value && audio) audio.pause() })">
        <button type="button" 
                @click="
                    if (!audio) {
                        audio = new Audio('{{ $state }}');
                        audio.onended = () => { playing = false; };
                    }
                    if (playing) {
                        audio.pause();
                        playing = false;
                    } else {
                        audio.play();
                        playing = true;
                    }
                "
                class="flex items-center justify-center w-7 h-7 rounded-full bg-primary/10 text-primary hover:bg-primary/20 transition-all border border-primary/20 shrink-0">
            <!-- Filament loads Heroicons by default, but let's use SVGs directly to ensure it works anywhere without loading fonts -->
            <svg x-show="!playing" class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd" />
            </svg>
            <svg x-show="playing" style="display: none;" class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M6.75 5.25a.75.75 0 0 1 .75-.75H9a.75.75 0 0 1 .75.75v13.5a.75.75 0 0 1-.75.75H7.5a.75.75 0 0 1-.75-.75V5.25Zm7.5 0A.75.75 0 0 1 15 4.5h1.5a.75.75 0 0 1 .75.75v13.5a.75.75 0 0 1-.75.75H15a.75.75 0 0 1-.75-.75V5.25Z" clip-rule="evenodd" />
            </svg>
        </button>
        <span class="text-[10px] text-gray-400 font-mono truncate max-w-[120px]">{{ basename($state) }}</span>
    </div>
@else
    <span class="text-xs text-gray-500 italic opacity-50">—</span>
@endif
