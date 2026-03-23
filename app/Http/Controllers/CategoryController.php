<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255|unique:categories,name",
            "description" => "nullable|string",
        ]);

        // Otomatis membuat slug dari name
        $validated["slug"] = Str::slug($request->name);

        Category::create($validated);

        return back()->with("success", "Category created successfully!");
    }
}
