<?php

namespace App\Http\Controllers\LandingDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCampaign;
use App\Models\StockUnit;

class PromoCampaignController extends Controller
{
    public function index()
    {
        $campaigns = PromoCampaign::with('stockUnits')->get();
        return view('landingdashboard.flash-sales.index', compact('campaigns'));
    }

    public function create()
    {
        return view('landingdashboard.flash-sales.create');
    }

    public function getItems(Request $request)
    {
        $query = StockUnit::query();
        if ($request->has('q') && !empty($request->q)) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        $items = $query->where('active', true)->limit(100)->get(['id', 'title']);
        
        return response()->json($items->map(function($item) {
            return ['id' => $item->id, 'name' => $item->title];
        })->values()->all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'headline' => 'required|string|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'enabled' => 'boolean',
            'stock_units' => 'array'
        ]);

        $promo = PromoCampaign::create($data);

        if (!empty($data['stock_units'])) {
            foreach ($data['stock_units'] as $unit) {
                $promo->stockUnits()->attach($unit['id'], [
                    'discount_rate' => $unit['discount_rate']
                ]);
            }
        }

        return redirect()->route('landingdashboard.flash-sales.index')
            ->with('success', 'Flash Sale created successfully.');
    }

    public function edit(PromoCampaign $flash_sale)
    {
        $selectedUnits = $flash_sale->stockUnits()->get();
        return view('landingdashboard.flash-sales.edit', compact('flash_sale', 'selectedUnits'));
    }
    public function update(Request $request, PromoCampaign $flash_sale)
    {
        $data = $request->validate([
            'headline' => 'required|string|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'enabled' => 'boolean',
            'stock_units' => 'array'
        ]);

        $flash_sale->update($data);

        $flash_sale->stockUnits()->sync([]);
        if (!empty($request->stock_units)) {
            foreach ($request->stock_units as $unit) {
                $flash_sale->stockUnits()->attach($unit['id'], [
                    'discount_rate' => $unit['discount_rate']
                ]);
            }
        }

        return redirect()->route('landingdashboard.flash-sales.index')
            ->with('success', 'Flash Sale updated successfully.');
    }

    public function destroy(PromoCampaign $flash_sale)
    {
        $flash_sale->delete();
        return redirect()->route('landingdashboard.flash-sales.index')
            ->with('success', 'Flash Sale deleted successfully.');
    }
}
