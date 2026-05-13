<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'password', 'google_id', 'avatar', 'points', 'reputation_score', 'is_public', 'bio', 'location', 'price_alerts_enabled', 'last_active_at', 'social_links', 'showcase_ids', 'profile_theme'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;



    public function getAvatarFrameAttribute(): string
    {
        return match(true) {
            $this->points >= 5000 => 'ring-4 ring-offset-4 ring-offset-background ring-[#ff4d4d] shadow-[0_0_20px_rgba(255,77,77,0.5)]', // Carbon/Red Master
            $this->points >= 2000 => 'ring-4 ring-offset-2 ring-offset-background ring-primary shadow-[0_0_15px_rgba(152,203,255,0.4)]', // Data Architect
            $this->points >= 500 => 'ring-2 ring-offset-2 ring-offset-background ring-yellow-500', // Elite Gold
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

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    public function getGarageStatsAttribute(): array
    {
        $favorites = $this->favorites()->get();
        if ($favorites->isEmpty()) return [
            'total_hp' => 0,
            'fav_brand' => 'N/A',
            'era' => 'N/A',
            'total_value' => 0
        ];

        $totalHp = 0;
        $totalValue = 0;
        $brands = [];
        $eras = [];

        foreach ($favorites as $car) {
            $totalHp += (int) ($car->hp[0] ?? 0);
            $totalValue += (int) $car->avg_price;
            foreach ($car->brands as $brand) {
                $brands[] = $brand->name;
            }
            $year = (int) substr($car->year, 0, 4);
            $eras[] = $year < 1990 ? 'Classic' : ($year < 2010 ? 'Modern' : 'Contemporary');
        }

        $brandCounts = array_count_values($brands);
        arsort($brandCounts);
        
        $eraCounts = array_count_values($eras);
        arsort($eraCounts);

        return [
            'total_hp' => $totalHp,
            'fav_brand' => array_key_first($brandCounts) ?? 'N/A',
            'era' => array_key_first($eraCounts) ?? 'N/A',
            'total_value' => $totalValue
        ];
    }

    public function getSpecialistTagsAttribute(): array
    {
        $tags = [];
        $stats = $this->garage_stats;
        
        if ($stats['total_hp'] > 5000) $tags[] = 'Horsepower King';
        if ($stats['era'] === 'Classic') $tags[] = 'Vintage Hunter';
        if ($stats['total_value'] > 1000000) $tags[] = 'High-Value Collector';
        if ($this->points > 1000) $tags[] = 'Wiki Veteran';
        if ($this->reputation_score > 50) $tags[] = 'Trusted Verifier';
        
        return array_slice($tags, 0, 3);
    }

    public function getBrandThemeAttribute(): string
    {
        $brand = $this->garage_stats['fav_brand'];
        return match($brand) {
            'BMW' => 'from-blue-600 via-purple-600 to-red-600',
            'Ferrari' => 'from-red-700 to-yellow-500',
            'Porsche' => 'from-gray-800 to-red-600',
            'Lamborghini' => 'from-yellow-600 to-black',
            'Mercedes-Benz' => 'from-gray-400 to-gray-800',
            default => 'from-primary/20 to-transparent',
        };
    }

    public function getContributionHeatmapAttribute(): array
    {
        $logs = $this->activityLogs()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $heatmap = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $heatmap[$date] = $logs[$date] ?? 0;
        }

        return $heatmap;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['admin', 'editor', 'super_admin']);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'social_links' => 'array',
            'showcase_ids' => 'array',
            'last_active_at' => 'datetime',
        ];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Car::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comparisonSets()
    {
        return $this->hasMany(ComparisonSet::class);
    }

    public function personalNotes()
    {
        return $this->hasMany(PersonalNote::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
