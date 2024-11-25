<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): CategoryCollection
    {
        return (new CategoryCollection(Category::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $category = new Category;
        $category->title = $request->title;
        if (Category::whereSlug(Str::slug($request->title))->exists()) {
            $count = Category::whereSlug('like' . Str::slug($request->title))->count();
            $category->slug = Str::slug($request->title) . '-' . $count + 1;
        } else {
            $category->slug = Str::slug($request->title);
        }
        $category->order = Category::first() ? Category::latest('order')->first()->order + 1 : 1;
        $category->save();
        return (new CategoryResource($category))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return (new CategoryResource($category))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        $category->title = $request->title;
        if (Category::whereSlug(Str::slug($request->title))->exists()) {
            $count = Category::whereSlug('like' . Str::slug($request->title))->count();
            $category->slug = Str::slug($request->title) . '-' . $count + 1;
        } else {
            $category->slug = Str::slug($request->title);
        }
        $category->save();
        return (new CategoryResource($category))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json(null, 204);
    }

    public function status(string $id, Request $request): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->status = $request->status ? 1 : 0;
        $category->save();
        return (new CategoryResource($category))->response()->setStatusCode(200);
    }
}
