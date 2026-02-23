@extends('landingdashboard.layouts.app')

@section('title', isset($stockUnit) ? __('messages.Edit Stock Unit') : __('messages.Add Stock Unit'))

@section('content')
<h1>{{ isset($stockUnit) ? __('messages.Edit Stock Unit') : __('messages.Add Stock Unit') }}</h1>

<form action="{{ isset($stockUnit) ? route('landingdashboard.stock-units.update', $stockUnit->id) : route('landingdashboard.stock-units.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($stockUnit)) @method('PUT') @endif

    <label>{{ __('messages.Title') }}</label>
    <input type="text" name="title" value="{{ old('title', $stockUnit->title ?? '') }}" required>

    <label>{{ __('messages.Department') }}</label>
    <select name="department_id">
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ (old('department_id', $stockUnit->department_id ?? '') == $dept->id) ? 'selected' : '' }}>{{ $dept->title }}</option>
        @endforeach
    </select>

    <label>{{ __('messages.Description') }}</label>
    <textarea name="description">{{ old('description', $stockUnit->description ?? '') }}</textarea>

    <label>{{ __('messages.Base Price') }}</label>
    <input type="number" name="base_price" value="{{ old('base_price', $stockUnit->base_price ?? 0) }}" step="0.01" required>

    <label>{{ __('messages.Quantity') }}</label>
    <input type="number" name="quantity" value="{{ old('quantity', $stockUnit->quantity ?? 0) }}" required>

    <label>{{ __('messages.Thumbnail') }}</label>
    <input type="file" name="thumbnail">
    @if(isset($stockUnit) && $stockUnit->thumbnail)
        <img src="{{ asset('storage/'.$stockUnit->thumbnail) }}" width="120" class="mt-2">
    @endif

    <label>{{ __('messages.Active') }}</label>
    <select name="active">
        <option value="1" {{ (old('active', $stockUnit->active ?? 1) == 1) ? 'selected' : '' }}>{{ __('messages.Yes') }}</option>
        <option value="0" {{ (old('active', $stockUnit->active ?? 1) == 0) ? 'selected' : '' }}>{{ __('messages.No') }}</option>
    </select>

    <button type="submit" class="btn">{{ isset($stockUnit) ? __('messages.Update') : __('messages.Create') }}</button>
</form>
@endsection
