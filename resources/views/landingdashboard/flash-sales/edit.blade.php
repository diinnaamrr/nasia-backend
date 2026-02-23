@extends('landingdashboard.layouts.app')

@section('title', __('messages.Edit Flash Sale'))

@section('content')
<div class="mb-4">
    <h2 class="mb-1">{{ __('messages.Edit Flash Sale') }}</h2>
    <p class="text-muted">{{ __('messages.Modify your existing campaign settings and products.') }}</p>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('landingdashboard.flash-sales.update', $flash_sale->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="headline">{{ __('messages.Campaign Headline') }}</label>
            <input type="text" name="headline" id="headline" placeholder="e.g. Exclusive Summer Offers" required value="{{ old('headline', $flash_sale->headline) }}">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="starts_at">{{ __('messages.Start Date & Time') }}</label>
                <input type="datetime-local" name="starts_at" id="starts_at" required value="{{ old('starts_at', $flash_sale->starts_at->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="form-group">
                <label for="ends_at">{{ __('messages.End Date & Time') }}</label>
                <input type="datetime-local" name="ends_at" id="ends_at" required value="{{ old('ends_at', $flash_sale->ends_at->format('Y-m-d\TH:i')) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="enabled">{{ __('messages.Status') }}</label>
            <select name="enabled" id="enabled">
                <option value="1" {{ old('enabled', $flash_sale->enabled) == 1 ? 'selected' : '' }}>{{ __('messages.Enabled (Published)') }}</option>
                <option value="0" {{ old('enabled', $flash_sale->enabled) == 0 ? 'selected' : '' }}>{{ __('messages.Disabled (Draft)') }}</option>
            </select>
        </div>

        <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">
        <h4 class="mb-3">{{ __('messages.Select Units & Set Discounts') }}</h4>
        
        <div class="form-group">
            <label>{{ __('messages.Add Stock Units') }}</label>
            <select id="stock_unit_search" class="form-control select2" style="width: 100%;">
                <option></option>
            </select>
        </div>

        <div id="selected_units_container" class="mt-4">
            @foreach($selectedUnits as $unit)
                <div class="card mb-2" id="unit_row_{{ $unit->id }}" style="padding: 1rem; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="font-weight: 600;">
                            <i class="fa-solid fa-box me-2"></i> {{ $unit->title }}
                            <input type="hidden" name="stock_units[{{ $unit->id }}][id]" value="{{ $unit->id }}">
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <label class="mb-0" style="font-size: 0.85rem;">{{ __('messages.Discount (%)') }}:</label>
                                <input type="number" name="stock_units[{{ $unit->id }}][discount_rate]" value="{{ $unit->pivot->discount_rate }}" min="0" max="100" style="width: 70px; padding: 5px;">
                            </div>
                            <button type="button" onclick="$('#unit_row_{{ $unit->id }}').remove()" class="btn btn-sm" style="color: #ef4444; background: none; padding: 5px;">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex gap-3">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 1rem;">
                <i class="fa-solid fa-save"></i> {{ __('messages.Save Changes') }}
            </button>
            <a href="{{ route('landingdashboard.flash-sales.index') }}" class="btn" style="background-color: #f1f5f9; color: var(--text-muted);">{{ __('messages.Cancel') }}</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stock_unit_search').select2({
            placeholder: "Search for stock units to add...",
            ajax: {
                url: '{{ route("landingdashboard.flash-sales.items.search") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return { text: item.name, id: item.id }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        }).on('select2:open', function() {
            var $searchField = $(".select2-search__field");
            if ($searchField.length > 0) {
                $searchField.val('').trigger('input');
            }
        });

        $('#stock_unit_search').on('select2:select', function (e) {
            var data = e.params.data;
            if ($('#unit_row_' + data.id).length === 0) {
                var html = `
                    <div class="card mb-2" id="unit_row_${data.id}" style="padding: 1rem; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-weight: 600;">
                                <i class="fa-solid fa-box me-2"></i> ${data.text}
                                <input type="hidden" name="stock_units[${data.id}][id]" value="${data.id}">
                            </div>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <label class="mb-0" style="font-size: 0.85rem;">Discount (%):</label>
                                    <input type="number" name="stock_units[${data.id}][discount_rate]" value="0" min="0" max="100" style="width: 70px; padding: 5px;">
                                </div>
                                <button type="button" onclick="$('#unit_row_${data.id}').remove()" class="btn btn-sm" style="color: #ef4444; background: none; padding: 5px;">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#selected_units_container').append(html);
            }
            $('#stock_unit_search').val(null).trigger('change');
        });
    });
</script>
@endpush
