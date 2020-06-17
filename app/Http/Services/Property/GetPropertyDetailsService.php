<?php

namespace App\Http\Services\Property;

use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;
use App\Http\Services\BaseService;

class GetPropertyDetailsService extends BaseService
{   
    private $propertyRepo;
    private $propertyMeta;

    public function __construct(
        PropertyRepository $propertyRepo,
        PropertyMetaRepository $propertyMeta
    ){
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
        if(isset($data['product_id'])){
            $list_of_products = $this->property->single($data['product_id']);
            if(!empty($list_of_products)){
                $list_of_products = $this->property_meta->getMeta($list_of_products);
                return $this->absorb([
                    'status' => 200,
                    'message' => 'Product Successfully Loaded',
                    'data' => $list_of_products,
                ]);
            } else {
                return $this->absorb([
                    'status' => 500,
                    'message' => 'No Product has been loaded',
                ]);
            }
        } elseif(isset($data['meta'])){
            $list_of_product_ids = $this->property_meta->getMetaWithValue($data);
            if(!empty($list_of_product_ids)){
                $property_details = $this->property->getDetailsWithMeta($list_of_product_ids);
                return $this->absorb([
                    'status' => 200,
                    'message' => 'Product Successfully Loaded',
                    'data' => $property_details,
                ]);
            } else {
                return $this->absorb([
                    'status' => 500,
                    'message' => 'No Product has been loaded',
                ]);
            }
            

        } else {
            $list_of_products = $this->property->all();
            if(!empty($list_of_products)){
                $list_of_products = $this->property_meta->getMeta($list_of_products);
                return $this->absorb([
                    'status' => 200,
                    'message' => 'Product Successfully Loaded',
                    'data' => $list_of_products,
                ]);
            } else {
                return $this->absorb([
                    'status' => 500,
                    'message' => 'No Product has been loaded',
                ]);
            }
        }
        
    }

}
