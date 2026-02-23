<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Store;
use App\CentralLogics\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StoreRegistrationController extends Controller
{
    /**
     * Check if user has trader documents uploaded
     */
    public function checkTraderStatus(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user_type' => $user->user_type,
            'has_trader_documents' => !empty($user->trader_image) && !empty($user->card_back) && !empty($user->card_face),
            'is_trader_approved' => $user->is_trader_approved,
            'trader_image' => $user->trader_image_full_url,
            'card_back' => $user->card_back_full_url,
            'card_face' => $user->card_face_full_url,
        ], 200);
    }

      /**
     * Check if trader has uploaded documents (for order placement)
     */
    public function hasUploadedDocuments(Request $request)
    {
        $user = $request->user();
        $hasDocuments = !empty($user->trader_image) && !empty($user->card_back) && !empty($user->card_face);
        
        return response()->json([
            'has_documents' => $hasDocuments,
            'user_type' => $user->user_type,
        ], 200);
    }
    /**
     * Register user as trader with documents
     */
    public function registerAsTrader(Request $request)
    {
        $user = $request->user();

        // Check if already has docs
        if (!empty($user->trader_image) && !empty($user->card_back) && !empty($user->card_face)) {
            return response()->json([
                'message' => $user->is_trader_approved ? translate('messages.trader_already_approved') : translate('messages.trader_registration_pending_approval'),
                'is_trader_approved' => $user->is_trader_approved,
            ], 200);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'trader_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'card_back' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'card_face' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        DB::beginTransaction();
        try {
            // Upload trader image
            if ($request->hasFile('trader_image')) {
                $trader_image = Helpers::upload('profile/', 'png', $request->file('trader_image'));
            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'trader_image', 'message' => translate('messages.trader_image_required')]
                    ]
                ], 403);
            }

            // Upload card back
            if ($request->hasFile('card_back')) {
                $card_back = Helpers::upload('profile/', 'png', $request->file('card_back'));
            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'card_back', 'message' => translate('messages.card_back_required')]
                    ]
                ], 403);
            }

            // Upload card face
            if ($request->hasFile('card_face')) {
                $card_face = Helpers::upload('profile/', 'png', $request->file('card_face'));
            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'card_face', 'message' => translate('messages.card_face_required')]
                    ]
                ], 403);
            }

            // Update user record
            $user->user_type = 'trader';
            $user->trader_image = $trader_image;
            $user->card_back = $card_back;
            $user->card_face = $card_face;
            $user->is_trader_approved = false; // Pending approval
            $user->save();

            // Store the files in storage table for tracking
            DB::table('storages')->updateOrInsert([
                'data_type' => get_class($user),
                'data_id' => $user->id,
                'key' => 'trader_image',
            ], [
                'value' => Helpers::getDisk(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('storages')->updateOrInsert([
                'data_type' => get_class($user),
                'data_id' => $user->id,
                'key' => 'card_back',
            ], [
                'value' => Helpers::getDisk(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('storages')->updateOrInsert([
                'data_type' => get_class($user),
                'data_id' => $user->id,
                'key' => 'card_face',
            ], [
                'value' => Helpers::getDisk(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'message' => translate('messages.trader_registration_successful'),
                'user_type' => $user->user_type,
                'is_trader_approved' => $user->is_trader_approved,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'errors' => [
                    ['code' => 'error', 'message' => $e->getMessage()]
                ]
            ], 403);
        }
    }

    /**
     * Update user type (customer or trader)
     * If trader and documents not uploaded, return error
     */
    public function updateUserType(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:customer,trader',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user_type = $request->user_type;

        // If selecting trader, check if documents are uploaded
        if ($user_type === 'trader') {
            if (empty($user->trader_image) || empty($user->card_back) || empty($user->card_face)) {
                return response()->json([
                    'errors' => [
                        ['code' => 'documents_required', 'message' => translate('messages.trader_documents_required')]
                    ],
                    'requires_documents' => true,
                ], 403);
            }
        }

        $user->user_type = $user_type;
        $user->save();

        return response()->json([
            'message' => translate('messages.user_type_updated'),
            'user_type' => $user->user_type,
        ], 200);
    }
      /**
     * Get trader's store with items
     */
    public function getTraderStore(Request $request)
    {
        $user = $request->user();

        if ($user->user_type !== 'trader') {
            return response()->json([
                'errors' => [
                    ['code' => 'not_trader', 'message' => translate('messages.user_not_trader')]
                ]
            ], 403);
        }

        if (!$user->vendor_id) {
            return response()->json([
                'message' => translate('messages.no_store_found'),
                'store' => null,
            ], 200);
        }

        $store = Store::where('vendor_id', $user->vendor_id)
            ->with(['items' => function($query) {
                $query->where('status', 1);
            }])
            ->first();

        if (!$store) {
            return response()->json([
                'message' => translate('messages.no_store_found'),
                'store' => null,
            ], 200);
        }

        return response()->json([
            'store' => $store,
        ], 200);
    }
}
