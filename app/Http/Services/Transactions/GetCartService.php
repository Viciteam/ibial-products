<?php

namespace App\Http\Services\Transactions;

use App\Http\Services\BaseService;

use App\Data\Repositories\Transactions\TransactionRepository;
use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;

class GetCartService extends BaseService
{   
    private $transactionRepo;

    public function __construct(
        TransactionRepository $transactionRepo,
        PropertyRepository $propertyRepo,
        PropertyMetaRepository $propertyMeta
    ){
        $this->transaction = $transactionRepo;
        $this->property = $propertyRepo;
        $this->property_meta = $propertyMeta;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($data)
    {   
        // dump($data);
        $cart_items = [];
        $transaction = $this->transaction->Getcart($data);
        foreach ($transaction as $key => $value) {
            $list_of_products = $this->property->single($value);
            $list_of_products = $this->property_meta->getMeta($list_of_products);
            array_push($cart_items, $list_of_products[0]);
        }
        return $this->absorb([
            'status' => 200,
            'message' => 'Items in Cart',
            'data' => $cart_items,
        ]);
        
    }

}
