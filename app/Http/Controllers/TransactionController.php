<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Transactions\PurchaseService;
use App\Http\Services\Transactions\AddCartService;
use App\Http\Services\Transactions\GetCartService;
use App\Http\Services\Transactions\CheckoutService;
use App\Http\Services\Transactions\GateService;
use App\Http\Services\Transactions\GateTransactionService;


class TransactionController extends Controller
{
    /**
     * Add Package
     */
    public function purchase(
        Request $request,
        PurchaseService $purchase
    )
    {
        $data = $request->all();
        return $purchase->handle($data);
    }

    public function addcart(
        Request $request,
        AddCartService $cart
    )
    {
        $data = $request->all();
        return $cart->handle($data);
    }

    public function getcart(
        Request $request,
        GetCartService $cart
    )
    {
        $data = $request->all();
        return $cart->handle($data);
    }

    public function checkout(
        Request $request,
        CheckoutService $checkout
    )
    {
        $data = $request->all();
        return $checkout->handle($data);
    }

    public function gate(
        Request $request,
        GateService $checkout
    )
    {
        $data = $request->all();
        $checkout->handle($data);
    }

    public function gatetransact(
        Request $request,
        GateTransactionService $checkout
    )
    {
        $data = $request->all();
        $checkout->handle($data);
    }


}
