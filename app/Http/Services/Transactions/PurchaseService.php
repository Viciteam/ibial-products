<?php

namespace App\Http\Services\Transactions;

use App\Http\Services\BaseService;

use App\Data\Repositories\Transactions\TransactionRepository;

class PurchaseService extends BaseService
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
        $transaction = $this->transaction->create($data);

        return $this->absorb($transaction);
        
    }

}
