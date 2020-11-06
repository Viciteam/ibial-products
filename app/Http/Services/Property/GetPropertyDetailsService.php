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
        // check if limit and page
        if(isset($data['limit']) || isset($data['page'])){
            if((!isset($data['limit']) || $data['limit'] == "") || (!isset($data['page']) || $data['page'] == "")){
                return $this->absorb([
                    'status' => 500,
                    'message' => 'Missing Limit or Page parameter',
                    'data' => [],
                ]);
            }
        }

        if(isset($data['product_id'])){ // get specific product
            $list_of_products = $this->property->single($data['product_id']);

            // if no product is returned
            if(empty($list_of_products)){
                return $this->absorb([
                    'status' => 500,
                    'message' => 'No Product has been loaded',
                ]);
            }

            $list_of_products = $this->property_meta->getMeta($list_of_products);
            return $this->absorb([
                'status' => 200,
                'message' => 'Product Successfully Loaded',
                'data' => $list_of_products,
            ]);
        } elseif(isset($data['meta'])){ // get product with meta
            $list_of_product_ids = $this->property_meta->getMetaWithValue($data);
            return $this->absorb($list_of_product_ids);
        } else { // get all products
            $list_of_products = $this->property->all($data);
            return $this->absorb($list_of_products);
        }
        
    }

}
