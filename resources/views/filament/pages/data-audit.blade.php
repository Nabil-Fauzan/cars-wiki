<x-filament-panels::page>
    <!-- Google Fonts & Material Symbols Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Inter:wght@400;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">

    <style>
        /* PCAR Premium Data Audit Styles (Non-Purgeable Custom Stylesheet) */
        .audit-container {
            font-family: 'Outfit', 'Inter', -apple-system, sans-serif;
            color: #cbd5e1;
        }

        /* Top Grid */
        .audit-stats-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 768px) {
            .audit-stats-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        /* Stats Cards */
        .audit-stat-card {
            background: rgba(26, 29, 35, 0.45);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 25px -15px rgba(0,0,0,0.5);
        }
        .audit-stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(152, 203, 255, 0.2);
            box-shadow: 0 15px 30px -10px rgba(0,0,0,0.6);
        }

        .audit-stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
        }
        .audit-stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1.1;
            margin-top: 0.5rem;
            letter-spacing: -0.04em;
        }
        .audit-stat-desc {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        .audit-icon-wrapper {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .audit-icon-wrapper span {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            text-align: center !important;
        }

        /* Section Cards */
        .audit-section-card {
            background: rgba(26, 29, 35, 0.35);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }

        .audit-section-header {
            padding: 1.25rem 1.5rem;
            border-b: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(15, 23, 42, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .audit-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #f1f5f9;
        }

        /* Color Tokens */
        .color-danger { color: #f87171; text-shadow: 0 0 15px rgba(248, 113, 113, 0.15); }
        .color-warning { color: #fbbf24; text-shadow: 0 0 15px rgba(251, 191, 36, 0.15); }
        .color-primary { color: #38bdf8; text-shadow: 0 0 15px rgba(56, 189, 248, 0.15); }

        .bg-danger-dim { background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .bg-warning-dim { background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.15); color: #f59e0b; }
        .bg-primary-dim { background: rgba(14, 165, 233, 0.1); border-color: rgba(14, 165, 233, 0.15); color: #0ea5e9; }

        /* Badges */
        .audit-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border: 1px solid transparent;
        }

        /* Custom Tables */
        .audit-table-wrapper {
            overflow-x: auto;
            width: 100%;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.85rem;
        }

        .audit-table th {
            padding: 1rem 1.5rem;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            background: rgba(15, 23, 42, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .audit-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            color: #cbd5e1;
            vertical-align: middle;
        }

        .audit-table tr {
            transition: background-color 0.2s;
        }

        .audit-table tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Progress Bar */
        .audit-progress-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            max-width: 10rem;
        }

        .audit-progress-bg {
            flex-grow: 1;
            height: 0.35rem;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .audit-progress-fill {
            height: 100%;
            border-radius: 9999px;
            background: #ef4444;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
        }

        /* Buttons */
        .audit-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .audit-btn-primary {
            background: rgba(152, 203, 255, 0.08);
            color: #98cbff;
            border-color: rgba(152, 203, 255, 0.2);
        }

        .audit-btn-primary:hover {
            background: rgba(152, 203, 255, 0.18);
            border-color: #98cbff;
            box-shadow: 0 0 12px rgba(152, 203, 255, 0.25);
            transform: scale(1.02);
        }
        .audit-btn-primary:active {
            transform: scale(0.98);
        }

        .audit-empty {
            padding: 3.5rem;
            text-align: center;
            color: #64748b;
            font-style: italic;
            font-size: 0.85rem;
        }
    </style>

    <div class="audit-container">
        <!-- Top Stats Overview Widget -->
        <div class="audit-stats-grid">
            <!-- Low Completion Card -->
            <div class="audit-stat-card">
                <div>
                    <p class="audit-stat-label">Low Data Completion</p>
                    <p class="audit-stat-value color-danger">{{ count($lowCompletion) }} Cars</p>
                    <p class="audit-stat-desc">Completeness score below 60%</p>
                </div>
                <div class="audit-icon-wrapper bg-danger-dim">
                    <span class="material-symbols-outlined text-[26px]">report</span>
                </div>
            </div>
            
            <!-- Pricing Valuations Card -->
            <div class="audit-stat-card">
                <div>
                    <p class="audit-stat-label">Pricing Valuation Gaps</p>
                    <p class="audit-stat-value color-warning">{{ count($missingPricing) }} Cars</p>
                    <p class="audit-stat-desc">Missing entry, peak, or avg prices</p>
                </div>
                <div class="audit-icon-wrapper bg-warning-dim">
                    <span class="material-symbols-outlined text-[26px]">payments</span>
                </div>
            </div>

            <!-- Exhaust Sound Card -->
            <div class="audit-stat-card">
                <div>
                    <p class="audit-stat-label">Missing Exhaust Sounds</p>
                    <p class="audit-stat-value color-primary">{{ count($missingAudio) }} Cars</p>
                    <p class="audit-stat-desc">Audio specimen URL is not populated</p>
                </div>
                <div class="audit-icon-wrapper bg-primary-dim">
                    <span class="material-symbols-outlined text-[26px]">volume_off</span>
                </div>
            </div>
        </div>

        <!-- Segmented Diagnostic Lists -->
        <div class="space-y-6">
            <!-- 1. Low Completion Table -->
            <div class="audit-section-card">
                <div class="audit-section-header">
                    <div class="audit-section-title">
                        <span class="material-symbols-outlined color-danger">warning</span>
                        <span>Critical Quality Audit (&lt; 60% Completion)</span>
                    </div>
                    <span class="audit-badge bg-danger-dim">Action Required</span>
                </div>
                <div class="audit-table-wrapper">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Model Name</th>
                                <th>Manufacturer</th>
                                <th>Data Quality</th>
                                <th style="text-align: right;">Moderation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowCompletion as $car)
                                <tr>
                                    <td style="font-weight: 700; color: #f1f5f9;">{{ $car->model }}</td>
                                    <td>{{ $car->brands->pluck('name')->implode('/') ?: 'N/A' }}</td>
                                    <td>
                                        <div class="audit-progress-container">
                                            <div class="audit-progress-bg">
                                                <div class="audit-progress-fill" style="width: {{ $car->data_completion }}%"></div>
                                            </div>
                                            <span style="font-weight: 700; font-size: 0.75rem;" class="color-danger">{{ $car->data_completion }}%</span>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('filament.admin.resources.cars.edit', ['record' => $car]) }}" class="audit-btn audit-btn-primary">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">edit</span> Edit Spec
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="audit-empty">No low data quality cars detected. Awesome job!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Missing Pricing Table -->
            <div class="audit-section-card">
                <div class="audit-section-header">
                    <div class="audit-section-title">
                        <span class="material-symbols-outlined color-warning">payments</span>
                        <span>Missing Pricing Valuations</span>
                    </div>
                    <span class="audit-badge bg-warning-dim">Value Gap</span>
                </div>
                <div class="audit-table-wrapper">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Model Name</th>
                                <th>Manufacturer</th>
                                <th>Pricing Status</th>
                                <th style="text-align: right;">Moderation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($missingPricing as $car)
                                <tr>
                                    <td style="font-weight: 700; color: #f1f5f9;">{{ $car->model }}</td>
                                    <td>{{ $car->brands->pluck('name')->implode('/') ?: 'N/A' }}</td>
                                    <td>
                                        <span class="audit-badge bg-warning-dim">Gaps Detected</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('filament.admin.resources.cars.edit', ['record' => $car]) }}" class="audit-btn audit-btn-primary">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">edit</span> Fix Price
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="audit-empty">All specimens have full valuation models loaded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Missing Audio Table -->
            <div class="audit-section-card">
                <div class="audit-section-header">
                    <div class="audit-section-title">
                        <span class="material-symbols-outlined color-primary">graphic_eq</span>
                        <span>Missing Exhaust Sounds</span>
                    </div>
                    <span class="audit-badge bg-primary-dim">Acoustic Gap</span>
                </div>
                <div class="audit-table-wrapper">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Model Name</th>
                                <th>Manufacturer</th>
                                <th>Audio Status</th>
                                <th style="text-align: right;">Moderation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($missingAudio as $car)
                                <tr>
                                    <td style="font-weight: 700; color: #f1f5f9;">{{ $car->model }}</td>
                                    <td>{{ $car->brands->pluck('name')->implode('/') ?: 'N/A' }}</td>
                                    <td>
                                        <span class="audit-badge bg-danger-dim">Silent</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('filament.admin.resources.cars.edit', ['record' => $car]) }}" class="audit-btn audit-btn-primary">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">edit</span> Add Exhaust
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="audit-empty">Excellent! Every engine has its sound specimen cataloged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
