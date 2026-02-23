@extends('landingdashboard.layouts.app')

@section('title', __('messages.Stock Units'))

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
    <div>
        <h2 style="font-size: 2rem; font-weight: 900; margin: 0; letter-spacing: -1px;">{{ __('messages.Stock Inventory') }}</h2>
        <p style="color: var(--text-muted); font-weight: 600; margin-top: 5px;">{{ __('messages.Monitor and manage the specific units available for distribution.') }}</p>
    </div>
    <a href="{{ route('landingdashboard.stock-units.create') }}" class="btn" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; display: flex; align-items: center; gap: 10px; box-shadow: 0 10px 20px -5px var(--primary-glow);">
        <i class="fa-solid fa-plus-circle" style="font-size: 1.1rem;"></i> {{ __('messages.Add Stock Unit') }}
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden; border-radius: 32px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Product Module') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Domain') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Price / Stock') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Status') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: center; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stockUnits as $unit)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: var(--transition);">
                    <td style="padding: 1.5rem 2rem;">
                        <div style="font-weight: 800; color: var(--text-main); font-size: 1rem;">{{ $unit->title }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">SKU-{{ str_pad($unit->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <span style="background: #f1f5f9; color: #475569; padding: 6px 14px; border-radius: 12px; font-size: 0.75rem; font-weight: 800; border: 1px solid #e2e8f0;">
                            {{ $unit->department->title }}
                        </span>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <div style="font-weight: 850; color: var(--text-main); font-size: 1.1rem;">{{ number_format($unit->base_price, 2) }} <small style="font-size: 0.65rem; color: #94a3b8; font-weight: 800;">EGP</small></div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700;">{{ $unit->quantity }} UNITS IN STOCK</div>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        @if($unit->active)
                            <span style="background: #f0fdf4; color: #16a34a; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(22, 163, 74, 0.1);"> 
                                <span style="width: 6px; height: 6px; background: #16a34a; border-radius: 50%;"></span> {{ __('messages.Operational') }}
                            </span>
                        @else
                            <span style="background: #fef2f2; color: #dc2626; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(220, 38, 38, 0.1);">
                                <span style="width: 6px; height: 6px; background: #dc2626; border-radius: 50%;"></span> {{ __('messages.Offline') }}
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <div style="display: flex; gap: 12px; justify-content: center;">
                            <a href="{{ route('landingdashboard.stock-units.edit', $unit->id) }}" style="width: 38px; height: 38px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: var(--primary); transition: var(--transition); text-decoration: none;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('landingdashboard.stock-units.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Purge this resource?');">
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
