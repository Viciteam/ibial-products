<?php

namespace App\Http\Services\Transactions;

use App\Http\Services\BaseService;

use App\Data\Repositories\Transactions\TransactionRepository;

class CheckoutService extends BaseService
{   
    private $transactionRepo;

    public function __construct(
        TransactionRepository $transactionRepo
    ){
        $this->transaction = $transactionRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($data)
    {   
        dump($data);
        // $transaction = $this->transaction->AddTocart($data);
        // return $this->absorb([
        //     'status' => 200,
        //     'message' => 'Inserted to Cart',
        //     'data' => [],
        // ]);
        
    }

}
