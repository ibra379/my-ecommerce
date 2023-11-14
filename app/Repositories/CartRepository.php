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

    public function increase(int $id)
    {
        \Cart::session(auth()->user()->id)
            ->update($id, [
                'quantity' => +1
            ]);
    }

    public function decrease(int $id)
    {
        $item = \Cart::session(auth()->user()->id)->get($id);

        if ($item->quantity === 1) {
            $this->remove($id);
            return;
        }

        \Cart::session(auth()->user()->id)
            ->update($id, [
                'quantity' => -1
            ]);
    }

    public function total()
    {
        return \Cart::session(auth()->user()->id)->getTotal();
    }

    public function jsonOrderItems(): string
    {
        return $this->content()
            ->map(fn($order) => [
                'name' => $order->name,
                'price' => $order->price,
                'quantity' => $order->quantity,
            ])->toJson();
    }

    public function remove(int $id)
    {
        \Cart::session(auth()->user()->id)->remove($id);
    }

    public function count(): int
    {
        return $this->content()->sum('quantity');
    }
}
