<?php

namespace App\Http\Services\Transactions;

use App\Http\Services\BaseService;

use App\Data\Repositories\Transactions\TransactionRepository;

class PayTransaction extends BaseService
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
        $method = $data['method']['method']; // get payments details
        $payment = $data['method']; // get payment 
        $transac = $data['info'];
        
        $headers = [
            "x-API-key: AQEnhmfuXNWTK0Qc+iSZsG05q8WYS4RYA4d968y/HvlO4bTv6z6Trr/WEMFdWw2+5HzctViMSCJMYAc=-a5B7wVzumQdp+lusxexyK5/Nlws1ZDp5Z/QJcNUyQ4k=-]u](6wk(NKG;nzD~",
            "content-type: application/json"
        ];

        $payload = [
            "merchantAccount" => "IBialAccountECOM", // merchant id
            "returnUrl" => "sample.com",
            "amount" => [
                "currency" => $payment['currency'],
                "value" => $payment['amount']
            ],
            "reference" => $payment['reference'],
            "paymentMethod" => [
                "type" => $method['type'],
                "holderName"  => $method['holderName'],
                "encryptedCardNumber" => $method['encryptedCardNumber'],
                "encryptedExpiryMonth" => $method['encryptedExpiryMonth'],
                "encryptedExpiryYear" => $method['encryptedExpiryYear'],
                "encryptedSecurityCode" => $method['encryptedSecurityCode']
            ],
        ];

        $subs_level = $data["info"]["transaction"];

        if($subs_level == "subscribe"){
            $payload["enableRecurring"] = true; // for recurring
            $payload["shopperInteraction"] = "Ecommerce"; // for recurring
            $payload["recurringProcessingModel"] = "Subscription"; // for recurring
        }

        $payload = json_encode($payload);
        // dump($payload);
        // exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://checkout-test.adyen.com/v64/payments");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        

        $output = curl_exec($ch);
        curl_close($ch);


        // $return = $output;
        $return = json_decode($output);
        
        return $return; 
        
    }

}
