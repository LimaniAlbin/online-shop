<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $brands = Brand::orderBy('updated_at', 'desc')->get();

        return response()->json($brands);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $brandData = $request->validate([
            'name' => 'required|unique:brands',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('logos'), $imageName);

            $brandData['logo'] = $imageName;
        }

        $brand = Brand::create($brandData);

        return response()->json([
            'message' => 'Brand created successfully',
            'brand' => $brand
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand): JsonResponse
    {
        return response()->json($brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): JsonResponse
    {
        return response()->json([
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand): JsonResponse
    {
        $brandData = $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('logos'), $imageName);

            $brandData['logo'] = $imageName;
        }

        $brand->fill($brandData)->save();

        return response()->json([
            'message' => 'Brand updated successfully',
            'brand' => $brand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $logo = $brand->logo;

        if ($logo) {
            Storage::disk('public')->delete('logos/' . $logo);
        }

        $products = $brand->products;

        foreach ($products as $product) {
            $product->delete();
        }

        $brand->delete();

        return response()->json([
            'message' => 'Brand and associated products deleted successfully!'
        ]);
    }
}
