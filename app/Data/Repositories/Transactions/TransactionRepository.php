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
                'transaction' => $transaction->id,
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
    
    public function get()
    {
        $info = $this->returnToArray($this->transaction->get());
        return $info;
    }

    public function insertBilling($data, $payment, $transaction)
    {

        DB::table('billing')->insert([
            "transaction_reference" => $payment->pspReference,
            "transaction_id" => $transaction['data']['transaction'],
            "scheme" => $data['subscription'],
            "price" => $data['price'],
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }

    public function insertBillingSchedule($data, $payment_details)
    {
        // dump($payment_details);
        // dump($data);

        DB::table('billing_schedule')->insert([
            "merchant_reference" => $payment_details["reference"],
            "next_payment" => Carbon::now()->addYear(1),
            "scheme" => $data['subscription'],
            "price" => $data['price'],
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
    
}
