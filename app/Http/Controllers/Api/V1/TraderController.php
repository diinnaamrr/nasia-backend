<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TraderController extends Controller
{
    // Dashboard Stats
    public function getDashboard(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader' || !$user->vendor_id) {
            return response()->json([
                'errors' => [['code' => 'forbidden', 'message' => translate('messages.user_not_authorized')]]
            ], 403);
        }

        $store = Store::where('vendor_id', $user->vendor_id)->first();
        if (!$store) {
            return response()->json([
                'errors' => [['code' => 'store_not_found', 'message' => translate('messages.store_not_found')]]
            ], 404);
        }

        $today = now()->format('Y-m-d');
        
        $total_orders = Order::where('store_id', $store->id)->count();
        $pending_orders = Order::where('store_id', $store->id)->where('order_status', 'pending')->count();
        $delivered_orders = Order::where('store_id', $store->id)->where('order_status', 'delivered')->count();
        $todays_orders = Order::where('store_id', $store->id)->whereDate('created_at', $today)->count();
        
        // Simple earning logic needed?
        // Maybe total_sales for now
        $total_sales = Order::where('store_id', $store->id)->where('order_status', 'delivered')->sum('order_amount');

        return response()->json([
            'total_orders' => $total_orders,
            'pending_orders' => $pending_orders,
            'delivered_orders' => $delivered_orders,
            'todays_orders' => $todays_orders,
            'total_sales' => round($total_sales, 2),
            'store_status' => (bool)$store->status,
        ], 200);
    }

    // List Orders (similar to vendor app but simplified)
    public function getOrders(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader' || !$user->vendor_id) {
            return response()->json([
                'errors' => [['code' => 'forbidden', 'message' => translate('messages.user_not_authorized')]]
            ], 403);
        }

        $store = Store::where('vendor_id', $user->vendor_id)->first();
         if (!$store) {
            return response()->json([
                'errors' => [['code' => 'store_not_found', 'message' => translate('messages.store_not_found')]]
            ], 404);
        }

        $limit = $request['limit'] ?? 10;
        $offset = $request['offset'] ?? 1;

        $paginator = Order::withoutGlobalScopes()
            ->where('store_id', $store->id)
            ->latest()
            ->paginate($limit, ['*'], 'page', $offset);

        $orders = [];
        foreach ($paginator->items() as $order) {
            // Log raw count for debugging
            $raw_count = \DB::table('order_details')->where('order_id', $order->id)->count();
            \Log::info("Trader API: Order ID {$order->id} raw details count: {$raw_count}");

            $order_data = Helpers::order_data_formatting($order, false);
            
            // Manually fetch details bypassing all scopes
            $details = OrderDetail::withoutGlobalScopes()
                ->where('order_id', $order->id)
                ->get();
            
            $formatted_details = Helpers::order_details_data_formatting($details);
            $order_data['details'] = $formatted_details;
            $order_data['details_count'] = count($formatted_details);

            $orders[] = $order_data;
        }

        return response()->json([
            'total_size' => $paginator->total(),
            'limit' => $limit,
            'offset' => $offset,
            'orders' => $orders
        ], 200);
    }

    public function toggleStoreStatus(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader' || !$user->vendor_id) {
            return response()->json([
                'errors' => [['code' => 'forbidden', 'message' => translate('messages.user_not_authorized')]]
            ], 403);
        }

        $store = Store::where('vendor_id', $user->vendor_id)->first();
        if (!$store) {
            return response()->json([
                'errors' => [['code' => 'store_not_found', 'message' => translate('messages.store_not_found')]]
            ], 404);
        }

        $store->active = $store->active ? 0 : 1;
        $store->save();

        return response()->json([
            'message' => $store->active ? translate('messages.store_opened') : translate('messages.store_temporarily_closed'),
            'active' => (bool)$store->active
        ], 200);
    }

    // Update Order Status (Mark as Ready/Delivered)
    public function updateOrderStatus(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader' || !$user->vendor_id) {
            return response()->json([
                'errors' => [['code' => 'forbidden', 'message' => translate('messages.user_not_authorized')]]
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'status' => 'required|in:processing,handover,delivered,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $store = Store::where('vendor_id', $user->vendor_id)->first();
        if (!$store) {
             return response()->json([
                'errors' => [['code' => 'store_not_found', 'message' => translate('messages.store_not_found')]]
            ], 404);
        }

        $order = Order::where('id', $request->order_id)->where('store_id', $store->id)->first();

        if (!$order) {
            return response()->json([
                'errors' => [['code' => 'order_not_found', 'message' => translate('messages.order_not_found')]]
            ], 404);
        }

        // Logic to update status
        $order->order_status = $request->status;
        if($request->status == 'delivered'){
            $order->payment_status = 'paid'; // Assume paid upon delivery for simplicity unless payment method dictates otherwise
             $order->delivered = now();
        }
        $order->save();
        
        // Notify customer
        Helpers::send_order_notification($order);

        return response()->json(['message' => translate('messages.order_status_updated')], 200);
    }

    // Simplified Item Management (View and Update Stock only)
    public function getItems(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader' || !$user->vendor_id) {
            return response()->json([
                'errors' => [['code' => 'forbidden', 'message' => translate('messages.user_not_authorized')]]
            ], 403);
        }

        $store = Store::where('vendor_id', $user->vendor_id)->first();
        if (!$store) {
            return response()->json([
                'errors' => [['code' => 'store_not_found', 'message' => translate('messages.store_not_found')]]
            ], 404);
        }

        $limit = $request['limit'] ?? 10;
        $offset = $request['offset'] ?? 1;

        $query = \App\Models\Item::where('store_id', $store->id)
            ->where('status', 1) 
            ->latest();

        $paginator = $query->paginate($limit, ['*'], 'page', $offset);

        // Convert query builder result to simpler array format if needed
        $data = Helpers::product_data_formatting($paginator->items(), true, true, app()->getLocale());

        return response()->json([
            'total_size' => $paginator->total(),
            'limit' => $limit,
            'offset' => $offset,
            'items' => $data
        ], 200);
    }

    public function updateStock(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader' || !$user->vendor_id) {
            return response()->json([
                'errors' => [['code' => 'forbidden', 'message' => translate('messages.user_not_authorized')]]
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'stock' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $store = Store::where('vendor_id', $user->vendor_id)->first();
        if (!$store) {
             return response()->json([
                'errors' => [['code' => 'store_not_found', 'message' => translate('messages.store_not_found')]]
            ], 404);
        }

        $item = \App\Models\Item::where('id', $request->item_id)->where('store_id', $store->id)->first();

        if (!$item) {
            return response()->json([
                'errors' => [['code' => 'item_not_found', 'message' => translate('messages.item_not_found')]]
            ], 404);
        }

        $item->stock = $request->stock;
        $item->save();

        return response()->json(['message' => translate('messages.product_stock_updated')], 200);
    }
}
