<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\StripeRepository;
use Illuminate\Http\Request;

class StripeCheckout2Controller extends Controller
{

    public function paymentIntent(CartRepository $cartRepository, StripeRepository $stripeRepository)
    {
        $stripeRepository->startPayment($cartRepository);
    }

    public function webhook(Request $request, StripeRepository $stripeRepository)
    {
        $stripeRepository->handle($request);
    }
}
