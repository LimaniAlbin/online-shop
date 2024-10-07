<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();
        $searchTerm = $request->input('text');
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('price', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $productsPerPage = 6;

        $totalItems = $query->count();
        $pageCount = ceil($totalItems / $productsPerPage);

        $products = $query->with(['brand', 'category'])
            ->orderBy('updated_at', 'desc')
            ->simplePaginate($productsPerPage);

        return response()->json([
            'paginate' => $products,
            'page_count' => $pageCount,
            'totalItems' => $totalItems
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        $brands = Brand::all();

        return response()->json([
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $productData = $request->validate([
            'name' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);

            $productData['image'] = $imageName;
        }

        $product = Product::create($productData);

        return response()->json([
            'message' => 'Product Created Successfully!',
            'product' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): JsonResponse
    {
        $brands = Brand::all();
        $categories = Category::all();

        return response()->json([
            'product' => $product,
            'brands' => $brands,
            '$categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $productData = $request->validate([
            'name' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                $imagePath = public_path('images/products') . '\\' . $product->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);

            $productData['image'] = $imageName;
        } else {
            unset($productData['image']);
        }


        $product->update($productData);

        return response()->json([
            'message' => 'Product Updated Successfully!',
            'product' => $product
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $image = $product->image;

        if ($image) {
            Storage::disk('public')->delete('images/products' . $image);
        }
        $product->delete();
        return response()->json([
            'message' => 'Product Deleted Successfully!'
        ]);
    }
}
