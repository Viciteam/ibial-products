<?php

namespace App\Http\Services\Transactions;

use App\Http\Services\BaseService;

use App\Data\Repositories\Transactions\TransactionRepository;

class GateTransactionService extends BaseService
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

        $headers = [
            "x-API-key: AQEnhmfuXNWTK0Qc+iSZsG05q8WYS4RYA4d968y/HvlO4bTv6z6Trr/WEMFdWw2+5HzctViMSCJMYAc=-a5B7wVzumQdp+lusxexyK5/Nlws1ZDp5Z/QJcNUyQ4k=-]u](6wk(NKG;nzD~",
            "content-type: application/json"
        ];
        $payload = json_encode([
            "merchantAccount" => "IBialAccountECOM", // merchant id
            "returnUrl" => "sample.com",
            "amount" => [
                "currency" => $data['currency'],
                "value" => $data['amount']
            ],
            "reference" => $data['reference'],
            "shopperInteraction" => "Ecommerce",
            "recurringProcessingModel" => "Subscription",
            "enableRecurring" => true,
            "paymentMethod" => [
                "type" => $data['method']['type'],
                "holderName"  => $data['method']['holderName'],
                "encryptedCardNumber" => $data['method']['encryptedCardNumber'],
                "encryptedExpiryMonth" => $data['method']['encryptedExpiryMonth'],
                "encryptedExpiryYear" => $data['method']['encryptedExpiryYear'],
                "encryptedSecurityCode" => $data['method']['encryptedSecurityCode']
            ],
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://checkout-test.adyen.com/v64/payments");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        

        $output = curl_exec($ch);
        curl_close($ch);


        $return = json_decode($output);
        
        dump($return); 

        //
        
    }

}
