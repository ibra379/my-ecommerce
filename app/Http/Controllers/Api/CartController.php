<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartRepository $cartRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'cartContent' => $this->cartRepository->content()
        ]);
    }

    public function count(): JsonResponse
    {
        return response()->json([
            'count' => $this->cartRepository->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $product = Product::whereId($request->input('productId'))->first();

        return response()->json([
            'count' => $this->cartRepository->add($product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function increase(int $id)
    {
        $this->cartRepository->increase($id);
        return response()->json([
            'cartContent' => $this->cartRepository->content(),
            'cartCount' => $this->cartRepository->count()
        ]);
    }

    public function decrease(int $id)
    {
        $this->cartRepository->decrease($id);
        return response()->json([
            'cartContent' => $this->cartRepository->content(),
            'cartCount' => $this->cartRepository->count()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cartRepository->remove($id);
        return response()->json([
            'cartContent' => $this->cartRepository->content(),
            'cartCount' => $this->cartRepository->count()
        ]);
    }
}
