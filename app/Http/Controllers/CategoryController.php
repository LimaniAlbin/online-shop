<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = Category::orderBy('updated_at', 'desc')->get();

        return response()->json($categories);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return response() -> json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $categoryData = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            $categoryData['image'] = $imageName;
        }

        $category = Category::create($categoryData);

        return response()->json([
            'message' => 'Category Created Successfully!',
            'category' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): JsonResponse
    {
        return response()->json([
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $categoryData = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                $imagePath = public_path('images/categories') . '/' . $category->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            $categoryData['image'] = $imageName;
        } else {
            unset($categoryData['image']);
        }

        $category->update($categoryData);

        return response()->json([
            'message' => 'Category Updated Successfully!',
            'category' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $products = $category->products;

        $image = $category->image;

        if ($image) {
            Storage::disk('public')->delete('images/categories' . $image);
        }

        foreach ($products as $product) {
            $product->delete();
        }

        $category->delete();

        return response()->json([
            'message' => 'Category and associated products deleted successfully!'
        ]);
    }
}
