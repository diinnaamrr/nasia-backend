<?php

namespace App\Http\Controllers\LandingDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockUnit;
use App\Models\Department;
use App\Models\PromoCampaign;
use Illuminate\Support\Str;

class StockUnitController extends Controller
{
    public function index()
    {
        $stockUnits = StockUnit::with('department')->get();
        return view('landingdashboard.stock-units.index', compact('stockUnits'));
    }

    public function create()
    {
        $departments = Department::where('visible', true)->get();
        $promoCampaigns = PromoCampaign::where('enabled', true)->get();
        return view('landingdashboard.stock-units.create', compact('departments', 'promoCampaigns'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'thumbnail' => 'nullable|image',
            'active' => 'boolean',
            'promo_campaigns' => 'array'
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('stock_units', 'public');
        }

        $stockUnit = StockUnit::create($data);

        if (!empty($data['promo_campaigns'])) {
            foreach ($data['promo_campaigns'] as $campaign) {
                $stockUnit->promoCampaigns()->attach($campaign['id'], [
                    'discount_rate' => $campaign['discount_rate']
                ]);
            }
        }

        return redirect()->route('landingdashboard.stock-units.index')
            ->with('success', 'Stock Unit created successfully.');
    }

    public function edit(StockUnit $stockUnit)
    {
        $departments = Department::where('visible', true)->get();
        $promoCampaigns = PromoCampaign::where('enabled', true)->get();
        $selectedCampaigns = $stockUnit->promoCampaigns->pluck('pivot.discount_rate', 'id')->toArray();
        return view('landingdashboard.stock-units.edit', compact('stockUnit', 'departments', 'promoCampaigns', 'selectedCampaigns'));
    }

    public function update(Request $request, StockUnit $stockUnit)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'thumbnail' => 'nullable|image',
            'active' => 'boolean',
            'promo_campaigns' => 'array'
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('stock_units', 'public');
        }

        $stockUnit->update($data);

        if (isset($data['promo_campaigns'])) {
            $stockUnit->promoCampaigns()->sync([]);
            foreach ($data['promo_campaigns'] as $campaign) {
                $stockUnit->promoCampaigns()->attach($campaign['id'], [
                    'discount_rate' => $campaign['discount_rate']
                ]);
            }
        }

        return redirect()->route('landingdashboard.stock-units.index')
            ->with('success', 'Stock Unit updated successfully.');
    }

    public function destroy(StockUnit $stockUnit)
    {
        $stockUnit->delete();
        return redirect()->route('landingdashboard.stock-units.index')
            ->with('success', 'Stock Unit deleted successfully.');
    }
}
