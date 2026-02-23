@extends('landingdashboard.layouts.app')

@section('title', __('messages.Create Flash Sale'))

@section('content')
<div class="mb-4">
    <h2 class="mb-1">{{ __('messages.Create Flash Sale') }}</h2>
    <p class="text-muted">{{ __('messages.Set up a new premium discount campaign for your landing page.') }}</p>
</div>

<div class="card" style="padding: 3rem; border-radius: 32px; max-width: 900px; margin: 0 auto;">
    <form action="{{ route('landingdashboard.flash-sales.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 2rem;">
            <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Campaign Headline') }}</label>
            <input type="text" name="headline" id="headline" placeholder="{{ __('messages.e.g. Supernova Seasonal Event') }}" required value="{{ old('headline') }}"
                   style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 2rem;">
            <div>
                <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Start Sequence') }}</label>
                <input type="datetime-local" name="starts_at" id="starts_at" required value="{{ old('starts_at') }}"
                       style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
            </div>
            <div>
                <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.End Sequence') }}</label>
                <input type="datetime-local" name="ends_at" id="ends_at" required value="{{ old('ends_at') }}"
                       style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
            </div>
        </div>

        <div style="margin-bottom: 3rem;">
            <label style="font-weight: 800; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block;">{{ __('messages.Availability State') }}</label>
            <select name="enabled" id="enabled" style="padding: 1.2rem; border-radius: 18px; font-weight: 600;">
                <option value="1" {{ old('enabled', 1) == 1 ? 'selected' : '' }}>{{ __('messages.Operational (Live)') }}</option>
                <option value="0" {{ old('enabled') == 0 ? 'selected' : '' }}>{{ __('messages.Standby (Draft)') }}</option>
            </select>
        </div>

        <div style="background: #f8fafc; border-radius: 24px; padding: 2.5rem; border: 1px solid #e2e8f0;">
            <h4 style="font-size: 1.1rem; font-weight: 900; margin-bottom: 1.5rem; letter-spacing: -0.5px;">{{ __('messages.Distribution Manifest') }}</h4>
            
            <div style="margin-bottom: 2rem;">
                <label style="font-weight: 800; font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">{{ __('messages.Inject Stock Units') }}</label>
                <select id="stock_unit_search" class="form-control select2" style="width: 100%;">
                    <option></option>
                </select>
            </div>

            <div id="selected_units_container">
                <!-- Dynamically added units will appear here -->
            </div>
        </div>

        <div style="margin-top: 3rem; display: flex; gap: 15px;">
            <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; flex: 1; border-radius: 18px; padding: 1.2rem; font-size: 1rem; box-shadow: 0 10px 20px -5px var(--primary-glow);">
                {{ __('messages.Launch Distribution') }}
            </button>
            <a href="{{ route('landingdashboard.flash-sales.index') }}" class="btn" style="background: #f1f5f9; color: #64748b; border-radius: 18px; padding: 1.2rem;">
                {{ __('messages.Abort') }}
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stock_unit_search').select2({
            placeholder: "Search for resources...",
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
                    <div class="card" id="unit_row_${data.id}" style="padding: 1.2rem; background: white; border: 1px solid #e2e8f0; border-radius: 18px; margin-bottom: 12px; transition: var(--transition);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 35px; height: 35px; background: #eef2ff; color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-cube"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 800; font-size: 0.9rem; color: var(--text-main);">${data.text}</div>
                                    <input type="hidden" name="stock_units[${data.id}][id]" value="${data.id}">
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 20px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <label style="margin: 0; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Discount %</label>
                                    <input type="number" name="stock_units[${data.id}][discount_rate]" value="0" min="0" max="100" 
                                           style="width: 80px; padding: 0.6rem; border-radius: 10px; font-weight: 700; text-align: center;">
                                </div>
                                <button type="button" onclick="$('#unit_row_${data.id}').remove()" style="background: #fff1f2; color: #e11d48; border: 1px solid #fecaca; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; transition: 0.3s;">
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
