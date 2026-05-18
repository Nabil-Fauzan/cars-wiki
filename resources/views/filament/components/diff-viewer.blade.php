@php
    $record = $getRecord();
    $car = $record->car;
    $proposed = $record->proposed_data;
    
    $fields = [
        'hp' => 'Horsepower Ratings',
        'engine' => 'Engine Options',
        'transmission' => 'Transmission',
        'drivetrain' => 'Drivetrain',
        'torque' => 'Torque',
        'zero_to_sixty' => '0-60 MPH',
        'top_speed' => 'Top Speed',
        'aerodynamics' => 'Aerodynamics',
        'braking' => 'Braking (ft)',
        'min_price' => 'Entry Price',
        'max_price' => 'Peak Price',
        'avg_price' => 'Market Average',
        'engine_sound_url' => 'Engine Sound URL',
        'marketplace_url' => 'Marketplace URL',
        'history' => 'Heritage History Text'
    ];
@endphp

<div class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/80 border-b border-gray-100 dark:border-gray-800 text-[10px] uppercase font-bold tracking-wider text-gray-400">
                    <th class="p-4 w-1/4">Specification Parameter</th>
                    <th class="p-4 w-3/8">Current Live Database Value</th>
                    <th class="p-4 w-3/8">Proposed User Value</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                @foreach($fields as $field => $label)
                    @php
                        $currentVal = $car->{$field};
                        $proposedVal = $proposed[$field] ?? null;
                        
                        // Stringify array data for preview
                        if (is_array($currentVal)) $currentVal = implode(', ', $currentVal);
                        if (is_array($proposedVal)) $proposedVal = implode(', ', $proposedVal);
                        
                        $isDifferent = ($proposedVal !== null && $proposedVal !== '' && $currentVal != $proposedVal);
                    @endphp
                    @if($proposedVal !== null && $proposedVal !== '')
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors {{ $isDifferent ? 'bg-success-500/5 dark:bg-success-500/5' : '' }}">
                            <td class="p-4 font-semibold text-gray-800 dark:text-gray-300">{{ $label }}</td>
                            <td class="p-4 text-gray-500 font-mono">{{ $currentVal ?: '—' }}</td>
                            <td class="p-4 font-mono {{ $isDifferent ? 'text-success-600 dark:text-success-400 font-bold bg-success-500/10' : 'text-gray-400' }}">
                                {{ $proposedVal }}
                                @if($isDifferent)
                                    <span class="ml-2 inline-flex px-1.5 py-0.5 rounded text-[8px] font-bold bg-success-500/20 text-success-600 dark:text-success-400">CHANGED</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
