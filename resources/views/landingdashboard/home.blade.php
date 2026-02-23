@extends('landingdashboard.layouts.app')

@section('title', 'System Overview')

@section('content')
<style>
    /* Premium Animations & Effects */
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Master Containers */
    .showcase-stage {
        background: linear-gradient(-45deg, #0f172a, #1e1b4b, #111827, #312e81);
        background-size: 400% 400%;
        animation: gradient-shift 12s ease infinite;
        border-radius: 40px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        margin-bottom: 50px;
        box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255,255,255,0.05);
    }

    @media (min-width: 768px) {
        .showcase-stage { padding: 60px; }
    }

    .showcase-stage::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.15), transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(168, 85, 247, 0.15), transparent 50%);
        pointer-events: none;
    }

    .glass-card-premium {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 35px;
        color: white;
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .glass-card-premium:hover {
        transform: translateY(-12px) scale(1.01);
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.15);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
    }

    .glass-card-premium::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
        transition: 0.5s;
    }

    .glass-card-premium:hover::before {
        animation: shine 1.5s infinite;
    }

    .status-badge-neon {
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .badge-live {
        background: rgba(74, 222, 128, 0.1);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.2);
    }

    .premium-progress-bar {
        height: 10px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        overflow: hidden;
        margin: 25px 0;
    }

    .premium-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #6366f1, #a855f7, #f43f5e);
        background-size: 200% 100%;
        animation: gradient-shift 4s linear infinite;
        border-radius: 20px;
        position: relative;
    }

    .btn-action-premium {
        background: white;
        color: #030712;
        padding: 14px 28px;
        border-radius: 18px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s;
        border: none;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .btn-action-premium:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 20px 30px rgba(99, 102, 241, 0.3);
        background: #f8fafc;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 950;
        letter-spacing: -1.5px;
        line-height: 1;
        margin-bottom: 20px;
        background: linear-gradient(to bottom right, #fff 30%, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    @media (min-width: 768px) {
        .hero-title {
            font-size: 4.5rem;
            letter-spacing: -3px;
            line-height: 0.95;
        }
    }

    /* Stat Cards */
    .stat-card-premium {
        background: white;
        padding: 40px;
        border-radius: 32px;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 25px;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
    }

    .stat-card-premium:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
        box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.08);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        transition: var(--transition);
    }

    .stat-card-premium:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
    }
</style>

<div class="showcase-stage">
    <div style="position: relative; z-index: 2;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px; flex-wrap: wrap; gap: 40px;">
            <div>
                <span style="background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 8px 20px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; letter-spacing: 2px; margin-bottom: 20px; display: inline-block;">{{ __('messages.OPERATIONAL CORE') }}</span>
                <h1 class="hero-title">{{ __('messages.Nexus Control') }}</h1>
                <p style="color: #94a3b8; font-size: 1.25rem; max-width: 550px; font-weight: 500; line-height: 1.6;">{{ __('messages.Precision management for your digital distribution engine. Monitor and scale your flash operations across all endpoints.') }}</p>
            </div>
            <div>
                <a href="{{ route('landingdashboard.flash-sales.create') }}" class="btn-action-premium">
                    <i class="fa-solid fa-plus-circle"></i> {{ __('messages.Initiate Deployment') }}
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
            @forelse($recent_flash_sales as $sale)
                @php
                    $now = \Carbon\Carbon::now();
                    $isActive = $sale->enabled && $now->between($sale->starts_at, $sale->ends_at);
                    $isScheduled = $sale->enabled && $now < $sale->starts_at;
                    
                    $totalDuration = $sale->starts_at->diffInSeconds($sale->ends_at);
                    $elapsed = $sale->starts_at->diffInSeconds($now, false);
                    $progress = $isActive ? min(100, max(0, ($elapsed / $totalDuration) * 100)) : ($isScheduled ? 0 : 100);
                @endphp

                <div class="glass-card-premium">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                        <div>
                            @if($isActive)
                                <span class="status-badge-neon badge-live mb-3">
                                    <span style="width: 10px; height: 10px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 15px #4ade80; animation: float 2s infinite;"></span> {{ __('messages.ENERGISED') }}
                                </span>
                            @elseif($isScheduled)
                                <span class="status-badge-neon mb-3" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <i class="fa-regular fa-clock"></i> {{ __('messages.SEQUENCING') }}
                                </span>
                            @else
                                <span class="status-badge-neon mb-3" style="background: rgba(255,255,255,0.05); color: #64748b; border: 1px solid rgba(255,255,255,0.08);">
                                    {{ __('messages.TERMINATED') }}
                                </span>
                            @endif
                            <h3 style="font-size: 1.8rem; font-weight: 900; margin: 0; letter-spacing: -0.8px; color: #fff;">{{ $sale->headline }}</h3>
                        </div>
                        <a href="{{ route('landingdashboard.flash-sales.edit', $sale->id) }}" style="width: 50px; height: 50px; border-radius: 16px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: white; transition: 0.3s; border: 1px solid rgba(255,255,255,0.1); text-decoration: none;">
                            <i class="fa-solid fa-sliders"></i>
                        </a>
                    </div>

                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                        <div style="display: flex; -webkit-mask-image: linear-gradient(to right, black 80%, transparent);">
                             @foreach($sale->stockUnits->take(4) as $unit)
                                <img src="{{ $unit->image_full_url }}" style="width: 40px; height: 40px; border-radius: 10px; border: 2px solid rgba(255,255,255,0.1); margin-right: -10px; background: #000; object-fit: contain;">
                             @endforeach
                        </div>
                        <span style="color: #94a3b8; font-size: 0.9rem; font-weight: 600;">+{{ max(0, $sale->stockUnits->count() - 4) }} Modules</span>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; font-weight: 800; margin-bottom: 12px; color: #94a3b8; letter-spacing: 1px;">
                            <span>SESSION COMPLETION</span>
                            <span style="color: #fff;">{{ number_format($progress, 0) }}%</span>
                        </div>
                        <div class="premium-progress-bar">
                            <div class="premium-progress-fill" style="width: {{ $progress }}%;"></div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                         <div style="background: rgba(0,0,0,0.3); padding: 18px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 5px;">Starts</div>
                            <div style="font-size: 0.95rem; font-weight: 700; color: #fff;">{{ $sale->starts_at->format('M d, H:i') }}</div>
                         </div>
                         <div style="background: rgba(0,0,0,0.3); padding: 18px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 5px;">Ends</div>
                            <div style="font-size: 0.95rem; font-weight: 700; color: #fff;">{{ $sale->ends_at->format('M d, H:i') }}</div>
                         </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; padding: 100px; text-align: center; background: rgba(255,255,255,0.02); border: 3px dashed rgba(255,255,255,0.08); border-radius: 40px;">
                    <i class="fa-solid fa-terminal" style="font-size: 3rem; color: rgba(255,255,255,0.1); margin-bottom: 25px;"></i>
                    <h3 style="color: white; font-weight: 900; font-size: 1.5rem;">{{ __('messages.Awaiting Commands') }}</h3>
                    <p style="color: #64748b; font-size: 1.1rem;">{{ __('messages.Your distribution pipeline is currently clear.') }}</p>
                </div>
            @endforelse
        </div>  
    </div>
</div>

<!-- Secondary Stats Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 60px;">
    <div class="stat-card-premium">
        <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
            <i class="fa-solid fa-bezier-curve"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Infrastructure</div>
            <div style="font-size: 2.2rem; font-weight: 900; color: #0f172a;">{{ $stats['departments'] }} <span style="font-size: 1rem; color: #94a3b8; font-weight: 600;">DEPTS</span></div>
        </div>
    </div>

    <div class="stat-card-premium">
        <div class="stat-icon" style="background: #fef2f2; color: #ef4444;">
            <i class="fa-solid fa-microchip"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Resources</div>
            <div style="font-size: 2.2rem; font-weight: 900; color: #0f172a;">{{ $stats['stock_units'] }} <span style="font-size: 1rem; color: #94a3b8; font-weight: 600;">UNITS</span></div>
        </div>
    </div>

    <div class="stat-card-premium">
        <div class="stat-icon" style="background: #f0fdf4; color: #22c55e;">
            <i class="fa-solid fa-atom"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">{{ __('messages.Deployments') }}</div>
            <div style="font-size: 2.2rem; font-weight: 900; color: #0f172a;">{{ $stats['flash_sales'] }} <span style="font-size: 1rem; color: #94a3b8; font-weight: 600;">{{ __('messages.TOTAL') }}</span></div>
        </div>
    </div>
</div>

@endsection

@endsection
