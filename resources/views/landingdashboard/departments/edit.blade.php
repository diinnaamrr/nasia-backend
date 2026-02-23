@extends('landingdashboard.layouts.app')

@section('title', isset($department) ? __('messages.Edit Department') : __('messages.Add Department'))

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 3rem;">
        <h2 style="font-size: 2rem; font-weight: 900; margin: 0; letter-spacing: -1px;">{{ isset($department) ? __('messages.Edit Department') : __('messages.Add Department') }}</h2>
        <p style="color: var(--text-muted); font-weight: 600; margin-top: 5px;">{{ __('messages.Adjust the parameters of your core distribution categories.') }}</p>
    </div>

    <div class="card" style="padding: 3rem; border-radius: 32px;">
        <form action="{{ isset($department) ? route('landingdashboard.departments.update', $department->id) : route('landingdashboard.departments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($department)) @method('PUT') @endif

            <div style="margin-bottom: 2rem;">
                <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Department Title') }}</label>
                <input type="text" name="title" value="{{ old('title', $department->title ?? '') }}" placeholder="e.g. Premium Groceries" required 
                       style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Visual Manifest (Cover Image)') }}</label>
                <div style="display: flex; gap: 20px; align-items: center; background: #f8fafc; padding: 20px; border-radius: 18px; border: 1px dashed #cbd5e1;">
                    <input type="file" name="cover_image" style="background: transparent; border: none; padding: 0;">
                    @if(isset($department) && $department->cover_image)
                        <img src="{{ asset('storage/'.$department->cover_image) }}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    @endif
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 3rem;">
                <div>
                    <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Visibility Status') }}</label>
                    <select name="visible" style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
                        <option value="1" {{ (old('visible', $department->visible ?? 1) == 1) ? 'selected' : '' }}>{{ __('messages.Publicly Visible') }}</option>
                        <option value="0" {{ (old('visible', $department->visible ?? 1) == 0) ? 'selected' : '' }}>{{ __('messages.Hidden from Users') }}</option>
                    </select>
                </div>
                <div>
                    <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Display Priority') }}</label>
                    <input type="number" name="display_order" value="{{ old('display_order', $department->display_order ?? 0) }}"
                           style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
                </div>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; flex: 1; border-radius: 18px; padding: 1.2rem; font-size: 1rem; box-shadow: 0 10px 20px -5px var(--primary-glow);">
                    {{ isset($department) ? __('messages.Update') : __('messages.Create') }}
                </button>
                <a href="{{ route('landingdashboard.departments.index') }}" class="btn" style="background: #f1f5f9; color: #64748b; border-radius: 18px; padding: 1.2rem;">
                    {{ __('messages.Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
