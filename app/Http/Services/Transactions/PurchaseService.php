<?php

namespace App\Http\Services\Transactions;

use App\Http\Services\BaseService;

use App\Data\Repositories\Transactions\TransactionRepository;
use App\Http\Services\Transactions\PayTransaction;

class PurchaseService extends BaseService
{   
    private $transactionRepo;
    private $payment;

    public function __construct(
        TransactionRepository $transactionRepo,
        PayTransaction $gateWay
    ){
        $this->transaction = $transactionRepo;
        $this->payment = $gateWay;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($data)
    {   

        // dump($data);

        if(!empty($data["transactions"])){
            // dump($data["transactions"]); 

            // payment
            // push payment as per transaction
            


            foreach ($data["transactions"] as $key => $value) {
                // dump($value);
                // push transaction as per item

                $payment_info = [
                    "method" => $data["payment"],
                    "info" => $value,
                ];
                
                // transac product
                $ispayed = $this->payment->handle($payment_info);
                // $ispayed = json_decode('{"additionalData":{"recurringProcessingModel":"Subscription"},"pspReference":"852600612155201J","resultCode":"Authorised","amount":{"currency":"PHP","value":150000},"merchantReference":"A123454"}');

                $isAuthorized = $ispayed->resultCode;
                
                if($isAuthorized == "Authorised"){
                    $transaction = $this->transaction->create($value);
                    $this->transaction->insertBilling($value, $ispayed, $transaction);

                    if($value['transaction'] == "subscribe"){
                        $this->transaction->insertBillingSchedule($value, $data["payment"]);  
                    }
                }
                // dump($ispayed);
                // $transaction = $this->transaction->create($value);
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
