<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeRepository
{
    public function __construct(
        private readonly string $clientSecret,
        private readonly string $webhookSecret = ''
    )
    {
        Stripe::setApiKey($this->clientSecret);
        Stripe::setApiVersion('2023-10-16');
    }

    public function startPayment(CartRepository $cartRepository)
    {
        $cart = $cartRepository->content();

        if ($cart->isEmpty()) {
            return to_route('products')->send();
        }
        $cartItems = $cart->map(fn($item) => [
            'quantity' => $item->quantity,
            'price_data' => [
                'currency' => 'EUR',
                'product_data' => [
                    'name' => $item->name,
                    'images' => [$item->associatedModel->image]
                ],
                'unit_amount' => $item->price
            ]
        ]);

        try {
            $session = Session::create([
                'line_items' => [...$cartItems->toArray()],
                'mode' => 'payment',
                'success_url' => config('app.url'),
                'cancel_url' => config('app.url'),
                'billing_address_collection' => 'required',
                'shipping_address_collection' => [
                    'allowed_countries' => ['IT']
                ],
                'metadata' => [
                    $cartRepository->jsonOrderItems()
                ],
                'customer_email' => 'idiallo37@gmail.com'
            ]);
//            dd($session);
            return redirect()->away($session->url)->send();
        } catch (ApiErrorException $e) {
            dd($e);
        }
    }

    public function handle(Request $request)
    {
        try {
            if (Storage::fileExists('stripe-event.completed')) {
                $event = unserialize(Storage::get('stripe-event.completed'));
            } else {
                //Qui recuperiamo dall header la firma du webhook
                $signature = $request->header('stripe-signature');

                //Qui recuperiamo il body che ci manda stripe
                $body = $request->getContent();

                //Creiamo un evento per assicurarsi che la chiave sia corretta!
                $event = Webhook::constructEvent(
                    $body,
                    $signature,
                    $this->webhookSecret
                );

                if ($event->type === 'checkout.session.completed') {
                    Storage::put('stripe-event.completed', serialize($event));
                }
            }

            $data = $event->data['object'];
            $client = new StripeClient($this->clientSecret);
            $items = $client->checkout->sessions->allLineItems($data['id']);

            foreach ($items as $item){
                dump($item->description);
            }
            dd($items);
        } catch (\Throwable $e) {
        }
    }
}
