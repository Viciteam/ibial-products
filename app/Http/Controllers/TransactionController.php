<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Transactions\PurchaseService;


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




}
