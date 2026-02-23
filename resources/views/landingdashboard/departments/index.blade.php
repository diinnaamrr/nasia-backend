@extends('landingdashboard.layouts.app')

@section('title', __('messages.Departments'))

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
    <div>
        <h2 style="font-size: 2rem; font-weight: 900; margin: 0; letter-spacing: -1px;">{{ __('messages.Core Departments') }}</h2>
        <p style="color: var(--text-muted); font-weight: 600; margin-top: 5px;">{{ __('messages.Manage the primary building blocks of your distribution network.') }}</p>
    </div>
    <a href="{{ route('landingdashboard.departments.create') }}" class="btn" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; display: flex; align-items: center; gap: 10px; box-shadow: 0 10px 20px -5px var(--primary-glow);">
        <i class="fa-solid fa-plus-circle" style="font-size: 1.1rem;"></i> {{ __('messages.New Department') }}
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden; border-radius: 32px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Identity') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Status') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Priority') }}</th>
                    <th style="padding: 1.5rem 2rem; text-align: center; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px;">{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: var(--transition);">
                    <td style="padding: 1.5rem 2rem;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 45px; height: 45px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: var(--primary);">
                                {{ substr($department->title, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 800; color: var(--text-main); font-size: 1rem;">{{ $department->title }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">DEP-{{ str_pad($department->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        @if($department->visible)
                            <span style="background: #f0fdf4; color: #16a34a; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(22, 163, 74, 0.1);">
                                <span style="width: 6px; height: 6px; background: #16a34a; border-radius: 50%;"></span> {{ __('messages.Visible') }}
                            </span>
                        @else
                            <span style="background: #f8fafc; color: #64748b; padding: 6px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #e2e8f0;">
                                <span style="width: 6px; height: 6px; background: #94a3b8; border-radius: 50%;"></span> {{ __('messages.Hidden') }}
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <span style="font-weight: 800; color: var(--text-main); background: #f1f5f9; padding: 4px 12px; border-radius: 8px;">{{ $department->display_order }}</span>
                    </td>
                    <td style="padding: 1.5rem 2rem;">
                        <div style="display: flex; gap: 12px; justify-content: center;">
                            <a href="{{ route('landingdashboard.departments.edit', $department->id) }}" style="width: 38px; height: 38px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: var(--primary); transition: var(--transition); text-decoration: none;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('landingdashboard.departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Decommission this department? This cannot be undone.');">
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
