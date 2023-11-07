<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function count(CartRepository $cartRepository)
    {
        return response()->json([
            'count' => $cartRepository->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cartRepository)
    {
        $product = Product::whereId($request->input('productId'))->first();

        return response()->json([
            'count' => $cartRepository->add($product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
