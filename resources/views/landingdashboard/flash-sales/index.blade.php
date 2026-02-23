@extends('landingdashboard.layouts.app')

@section('title', __('messages.Distribution Sessions'))

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
    <div>
        <h2 style="font-size: 2rem; font-weight: 900; margin: 0; letter-spacing: -1px;">{{ __('messages.Distribution Sessions') }}</h2>
        <p style="color: var(--text-muted); font-weight: 600; margin-top: 5px;">{{ __('messages.Configure and monitor high-frequency promotional events.') }}</p>
    </div>
    <a href="{{ route('landingdashboard.flash-sales.create') }}" class="btn" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; display: flex; align-items: center; gap: 10px; box-shadow: 0 10px 20px -5px var(--primary-glow);">
        <i class="fa-solid fa-bolt-lightning" style="font-size: 1.1rem;"></i> {{ __('messages.Create Session') }}
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden; border-radius: 32px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Session Data') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Timeline') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Manifest') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.State') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: center; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $campaign)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: var(--transition);">
                    <td style="padding: 1.5rem 2rem;">
                        <div style="font-weight: 800; color: var(--text-main); font-size: 1.1rem;">{{ $campaign->headline }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">SESSION-{{ str_pad($campaign->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <div style="display: flex; flex-direction: column; gap: 5px;">
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700;">
                                <i class="fa-regular fa-calendar-check" style="color: #10b981;"></i>
                                <span style="color: #1e293b;">{{ $campaign->starts_at->format('M d, H:i') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700;">
                                <i class="fa-regular fa-calendar-xmark" style="color: #ef4444;"></i>
                                <span style="color: #1e293b;">{{ $campaign->ends_at->format('M d, H:i') }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <div style="display: flex; flex-wrap: wrap; gap: 6px; max-width: 300px;">
                            @foreach($campaign->stockUnits->take(3) as $unit)
                                <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-tag" style="font-size: 0.6rem; color: var(--primary);"></i>
                                    {{ $unit->title }} ({{ $unit->pivot->discount_rate }}%)
                                </span>
                            @endforeach
                            @if($campaign->stockUnits->count() > 3)
                                <span style="background: #fff; color: var(--text-muted); padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; border: 1px solid #e2e8f0;">
                                    +{{ $campaign->stockUnits->count() - 3 }} MORE
                                </span>
                            @endif
                        </div>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        @if($campaign->enabled)
                            @if(\Carbon\Carbon::now()->between($campaign->starts_at, $campaign->ends_at))
                                <span style="background: #f0fdf4; color: #16a34a; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(22, 163, 74, 0.1);">
                                    <span style="width: 6px; height: 6px; background: #16a34a; border-radius: 50%; box-shadow: 0 0 10px #16a34a;"></span> {{ __('messages.ENERGISED') }}
                                </span>
                            @else
                                <span style="background: #eff6ff; color: #3b82f6; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(59, 130, 246, 0.1);">
                                    <span style="width: 6px; height: 6px; background: #3b82f6; border-radius: 50%;"></span> {{ __('messages.SEQUENCING') }}
                                </span>
                            @endif
                        @else
                            <span style="background: #f8fafc; color: #64748b; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #e2e8f0;">
                                <span style="width: 6px; height: 6px; background: #94a3b8; border-radius: 50%;"></span> {{ __('messages.DEACTIVATED') }}
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <div style="display: flex; gap: 12px; justify-content: center;">
                            <a href="{{ route('landingdashboard.flash-sales.edit', $campaign->id) }}" style="width: 38px; height: 38px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: var(--primary); transition: var(--transition); text-decoration: none;">
                                <i class="fa-solid fa-sliders"></i>
                            </a>
                            <form action="{{ route('landingdashboard.flash-sales.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.Abort deployment?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width: 38px; height: 38px; border-radius: 12px; background: #fff1f2; border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; color: #e11d48; transition: var(--transition); cursor: pointer;">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
