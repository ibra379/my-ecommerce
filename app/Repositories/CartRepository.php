<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartRepository
{
    public function add(Product $product): int
    {
        \Cart::session(auth()->user()->id)->add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [],
            'associatedModel' => $product
        ]);

        return $this->count();
    }

    public function content(): Collection
    {
        return \Cart::session(auth()->user()->id)->getContent();
    }

    public function count(): int
    {
        return $this->content()->sum('quantity');
    }
}
