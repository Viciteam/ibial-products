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
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $transaction = $this->transaction->create($value);
            }
            return $this->absorb([
                'status' => 200,
                'message' => 'Success Inserted Transactions'
            ]);
        } else {
            return $this->absorb([
                'status' => 500,
                'message' => 'Enpty Transactions'
            ]);
        }
        

        
        
    }

}
