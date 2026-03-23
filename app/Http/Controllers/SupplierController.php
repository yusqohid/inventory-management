<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "contact_person" => "required|string|max:255",
            "email" => "required|email|unique:suppliers,email",
            "phone" => "required|string|max:20",
            "address" => "nullable|string",
        ]);

        Supplier::create($validated);

        return back()->with("success", "Supplier added successfully!");
    }
}
