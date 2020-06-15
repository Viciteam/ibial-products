<?php

namespace App\Http\Services\Property;

use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;
use App\Http\Services\BaseService;

class CreatePropertyService extends BaseService
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
        // add product
        $product_id = $this->property->create($data);

        $meta = [];
        $meta['product_id'] = $product_id;
        $meta['meta'] = $data['meta'];
        
        // add product meta
        $this->property_meta->create($meta);

        return $this->absorb([
            'status' => 200,
            'message' => 'Product Successfully Created',
            'data' => [
                'product_id' => $product_id,
            ],
        ]);
    }

}
