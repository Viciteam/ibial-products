<?php

namespace App\Http\Services\Property;

use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;
use App\Http\Services\BaseService;

class EditPropertyService extends BaseService
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
        // update product info
        $product_update = $this->property->update($data['id'], $data);

        if(isset($data['meta'])){
            $this->property_meta->update($data['id'], $data['meta']);
        }
        
        // dd($product_update);
        if($product_update){
            return $this->absorb([
                'status' => 200,
                'message' => 'Product Successfully Updated',
                'data' => [
                    'product_id' => $data['id'],
                ],
            ]);
        } else {
            return $this->absorb([
                'status' => 500,
                'message' => 'An error has occurred while saving the Product.',
            ]);
        }
        

    }

}
