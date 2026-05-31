<?php

namespace App\Traits;

trait CarMetrics
{
    public function calculateDataCompletion(): int
    {
        $fields = [
            'model', 'year', 'category', 'image_url', 
            'zero_to_sixty', 'top_speed', 'history', 
            'torque', 'transmission', 'drivetrain',
            'engine_sound_url', 'min_price', 'max_price', 
            'price_trend', 'marketplace_url'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            $val = $this->$field;
            if (is_numeric($val) || !empty($val)) $filled++;
        }

        $extraChecks = 0;
        if (!empty($this->pros) && count($this->pros) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($this->cons) && count($this->cons) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($this->engine) && count($this->engine) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($this->gallery) && count($this->gallery) > 0) { $filled++; }
        $extraChecks++;

        // Using relationship count if loaded, otherwise check DB
        if ($this->relationLoaded('brands')) {
            if ($this->brands->count() > 0) $filled++;
        } elseif ($this->brands()->exists()) {
            $filled++;
        }
        $extraChecks++;

        $totalPossible = count($fields) + $extraChecks;

        return (int) round(($filled / $totalPossible) * 100);
    }

    public function calculateSeoScore(): int
    {
        $score = 0;
        if (strlen($this->history ?? '') > 200) $score += 30;
        if (strlen($this->history ?? '') > 500) $score += 20;
        if ($this->image_url) $score += 10;
        if (count($this->gallery ?? []) >= 3) $score += 10;
        if (count($this->pros ?? []) >= 3) $score += 10;
        if (count($this->cons ?? []) >= 3) $score += 10;
        if ($this->category) $score += 10;
        
        return min(100, $score);
    }
}
