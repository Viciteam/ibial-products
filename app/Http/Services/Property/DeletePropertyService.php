<?php

namespace App\Http\Services\Property;

use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;
use App\Http\Services\BaseService;

class DeletePropertyService extends BaseService
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
    public function handle(int $id)
    {   
        // delete property details
        $product_delete = $this->property->delete($id);

        // delete product meta
        $this->property_meta->delete($id);

        if($product_delete){
            return $this->absorb([
                'status' => 200,
                'message' => 'Product Successfully Deleted',
                'data' => [],
            ]);
        } else {
            return $this->absorb([
                'status' => 500,
                'message' => 'An error has occurred while deleting the Product.',
            ]);
        }
    }

}
