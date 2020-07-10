<?php


namespace App\Data\Repositories\Transactions;



use App\Data\Models\Transaction\TransactionModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\Redis;
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

    public function AddTocart($data)
    {
        $cart = Redis::get('cart:'.$data['user_id']);
        $cart = json_decode($cart);

        // if no current log, make a new log
        if($cart === NULL){
            $cart = [];
        }
        
        $product_exist = $this->inArray($data['product_id'], $cart);
        if(!$product_exist){
            array_push($cart, $data['product_id']);
        }

        Redis::set('cart:'.$data['user_id'], json_encode($cart));

        return true;
    }

    public function Getcart($data)
    {
        $cart = Redis::get('cart:'.$data['user_id']);
        $cart = json_decode($cart);

        // if no current log, make a new log
        if($cart === NULL){
            $cart = [];
        }

        return $cart;

    }
    

    
}
