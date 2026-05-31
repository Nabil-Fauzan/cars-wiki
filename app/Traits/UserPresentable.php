<?php

namespace App\Traits;

trait UserPresentable
{
    public function getAvatarFrameAttribute(): string
    {
        return match(true) {
            $this->points >= 5000 => 'ring-4 ring-offset-4 ring-offset-background ring-[#ff4d4d] shadow-[0_0_20px_rgba(255,77,77,0.5)]',
            $this->points >= 2000 => 'ring-4 ring-offset-2 ring-offset-background ring-primary shadow-[0_0_15px_rgba(152,203,255,0.4)]',
            $this->points >= 500 => 'ring-2 ring-offset-2 ring-offset-background ring-yellow-500',
            default => 'ring-1 ring-outline-variant/30',
        };
    }

    public function getThemeClassesAttribute(): string
    {
        return match($this->profile_theme) {
            'midnight' => 'bg-[#05070a] text-blue-400 border-blue-900/30',
            'racing-green' => 'bg-[#0a1a10] text-emerald-400 border-emerald-900/30',
            'stealth' => 'bg-[#0f0f0f] text-gray-400 border-gray-800',
            'cyberpunk' => 'bg-[#120422] text-fuchsia-400 border-fuchsia-900/30',
            default => 'bg-background text-on-surface border-outline-variant/20',
        };
    }

    public function getRankAttribute(): string
    {
        return match(true) {
            $this->points >= 5000 => 'Master Curator',
            $this->points >= 2000 => 'Data Architect',
            $this->points >= 500 => 'Elite Spotter',
            $this->points >= 100 => 'Enthusiast',
            default => 'Rookie Observer',
        };
    }

    public function getSpecialistTagsAttribute(): array
    {
        $tags = [];
        $stats = $this->garage_stats;
        
        if (($stats['total_hp'] ?? 0) > 5000) $tags[] = 'Horsepower King';
        if (($stats['era'] ?? '') === 'Classic') $tags[] = 'Vintage Hunter';
        if (($stats['total_value'] ?? 0) > 1000000) $tags[] = 'High-Value Collector';
        if ($this->points > 1000) $tags[] = 'Wiki Veteran';
        if ($this->reputation_score > 50) $tags[] = 'Trusted Verifier';
        
        return array_slice($tags, 0, 3);
    }

    public function getBrandThemeAttribute(): string
    {
        $brand = $this->garage_stats['fav_brand'] ?? 'N/A';
        return match($brand) {
            'BMW' => 'from-blue-600 via-purple-600 to-red-600',
            'Ferrari' => 'from-red-700 to-yellow-500',
            'Porsche' => 'from-gray-800 to-red-600',
            'Lamborghini' => 'from-yellow-600 to-black',
            'Mercedes-Benz' => 'from-gray-400 to-gray-800',
            default => 'from-primary/20 to-transparent',
        };
    }
}
