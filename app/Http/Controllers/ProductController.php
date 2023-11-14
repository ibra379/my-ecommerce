<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Sleep;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::inRandomOrder()
            ->whereActive(true)
            ->take(16)
            ->get();

        return view('products.index', [
            'products' => $products
        ]);
    }
}
