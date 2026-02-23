@extends('landingdashboard.layouts.app')

@section('title', isset($department) ? __('messages.Edit Department') : __('messages.Add Department'))

@section('content')
<h1>{{ isset($department) ? __('messages.Edit Department') : __('messages.Add Department') }}</h1>

<form action="{{ isset($department) ? route('landingdashboard.departments.update', $department->id) : route('landingdashboard.departments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($department)) @method('PUT') @endif

    <label>{{ __('messages.Title') }}</label>
    <input type="text" name="title" value="{{ old('title', $department->title ?? '') }}" required>

    <label>{{ __('messages.Cover Image') }}</label>
    <input type="file" name="cover_image">
    @if(isset($department) && $department->cover_image)
        <img src="{{ asset('storage/'.$department->cover_image) }}" width="120" class="mt-2">
    @endif

    <label>{{ __('messages.Visible') }}</label>
    <select name="visible">
        <option value="1" {{ (old('visible', $department->visible ?? 1) == 1) ? 'selected' : '' }}>{{ __('messages.Yes') }}</option>
        <option value="0" {{ (old('visible', $department->visible ?? 1) == 0) ? 'selected' : '' }}>{{ __('messages.No') }}</option>
    </select>

    <label>{{ __('messages.Display Order') }}</label>
    <input type="number" name="display_order" value="{{ old('display_order', $department->display_order ?? 0) }}">

    <button type="submit" class="btn">{{ isset($department) ? __('messages.Update') : __('messages.Create') }}</button>
</form>
@endsection
