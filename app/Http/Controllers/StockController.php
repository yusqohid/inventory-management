<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function adjust(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity'  => 'required|integer|not_in:0', // + for in, - for out
            'type'      => 'required|in:in,out,adjustment,return',
            'reference' => 'nullable|string|max:50',
            'notes'     => 'nullable|string',
        ]);

        // Wrap in a transaction to ensure both updates happen or neither does
        DB::transaction(function () use ($validated, $product) {

            // 1. Update the Product's main quantity
            $product->increment('quantity', $validated['quantity']);

            // 2. Record the movement in the ledger
            $product->movements()->create([
                'user_id'   => Auth::id(),
                'quantity'  => $validated['quantity'],
                'type'      => $validated['type'],
                'reference' => $validated['reference'],
                'notes'     => $validated['notes'],
            ]);

            // 3. Validation: Prevent negative stock (Optional for MVP)
            if ($product->fresh()->quantity < 0) {
                throw new \Exception("Insufficient stock for this operation.");
            }
        });

        return back()->with('success', 'Stock updated successfully!');
    }
}
