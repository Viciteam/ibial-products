<?php


namespace App\Data\Repositories\Transactions;



use App\Data\Models\Transaction\TransactionModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class TransactionRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $transaction;

    /**
     * TransactionRepository constructor.
     * @param Fund 
     */
    public function __construct(
        TransactionModel $transactionModel
    ){
        $this->transaction = $transactionModel;
    }

    public function create($data)
    {
        // initialize model
        $transaction = $this->transaction->init($data);
       
        if (!$transaction->validate($data)) {
            $errors = $transaction->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the transaction.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion
        if (!$transaction->save()) {
            $errors = $transaction->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the transaction.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }
        
        return [
            'status' => 200,
            'message' => 'Successfully saved the transactions.',
            'data' => [
                'transaction' => $transaction->ID,
            ],
        ];
    }


    
    

    
}
