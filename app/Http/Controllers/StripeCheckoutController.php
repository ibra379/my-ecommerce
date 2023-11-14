<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Contracts\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeCheckoutController extends Controller
{
    public function create(): View
    {
        return view('stripe.create');
    }

    public function paymentIntent(CartRepository $cartRepository)
    {
        $stripe = new StripeClient(config('stripe.test_secret_key'));

        header('Content-Type: application/json');

        try {
            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $cartRepository->total(),
                'currency' => 'eur',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'order_items' => $cartRepository->jsonOrderItems()
                ]
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
