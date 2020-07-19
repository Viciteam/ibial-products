<?php

namespace App\Http\Services\Logs;

use App\Data\Repositories\Logs\ViewLogsRepository;
use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;
use App\Data\Repositories\Transactions\TransactionRepository;

use App\Http\Services\BaseService;

class SuggestedService extends BaseService
{   
    private $logs;
    private $transactions;
    private $propertyRepo;
    private $propertyMeta;

    public function __construct(
        ViewLogsRepository $logs,
        TransactionRepository $transaction,
        PropertyRepository $propertyRepo,
        PropertyMetaRepository $propertyMeta
    ){
        $this->logs = $logs;
        $this->transactions = $transaction;
        $this->property = $propertyRepo;
        $this->property_meta = $propertyMeta;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        $limit = (isset($data['limit']) ? $data['limit'] : 5);
        $list_of_logs = [];

        // get logs
        $logs = $this->logs->get($data);
        foreach ($logs as $logkey => $logvalue) {
            array_push($list_of_logs, $logvalue);
        }

        // get transactions
        $transac = $this->transactions->get();
        foreach ($transac as $transac_key => $transac_value) {
            array_push($list_of_logs, (int) $transac_value['product_id']);
        }

        // array unique
        $new_logs = array_unique($list_of_logs);

        // get product reference info
        $reference_products = [];
        $reference_metas = [];
        foreach ($new_logs as $key => $value) {
            $list_of_products = $this->property->single($value);
            $meta_info = $this->property_meta->get_only_meta($list_of_products);
            array_push($reference_products, $list_of_products[0]);
            array_push($reference_metas, $meta_info);
        }

        // get related by name and description
        $related_products = $this->property->related($reference_products);

        // get related by meta
        $related_by_meta = $this->property_meta->related($reference_metas);
        
        // reform reference_products
        $ref_prod = array_unique($related_products);

        // reform related_by_meta
        $ref_meta = array_unique($related_by_meta);

        // merge products and meta
        $merged = array_merge($ref_prod, $ref_meta);

        // product key list
        $ref_list = [];
        foreach ($merged as $rpkey => $rpvalue) {
            $ref_list[$rpvalue] = 0;
        }
        
        // reference counter
        foreach ($merged as $rckey => $rcvalue) {
            $ref_list[$rcvalue]++;
        }

        // filter reference
        foreach ($new_logs as $frkey => $frvalue) {
            unset($ref_list[$frvalue]);
        }

        $final_suggestion = [];
        foreach ($ref_list as $fskey => $fsvalue) {
            $list_of_products = $this->property->single($fskey);
            $list_of_products = $this->property_meta->getMeta($list_of_products);
            array_push($final_suggestion, $list_of_products[0]);
        }

        return $this->absorb([
            'status' => 200,
            'message' => 'Suggested Products',
            'data' => $final_suggestion
        ]);
    }

}
