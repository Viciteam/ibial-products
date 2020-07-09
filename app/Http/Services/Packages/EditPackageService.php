<?php

namespace App\Http\Services\Packages;

use App\Http\Services\BaseService;

use App\Data\Repositories\Packages\PackagesRepository;
use App\Data\Repositories\Packages\PropertiesRepository;
use App\Data\Repositories\Packages\ExtraOrderRepository;
use App\Data\Repositories\Packages\PricesRepository;

class EditPackageService extends BaseService
{   
    private $packageRepo;
    private $propertiesRepo;
    private $extraOrderRepo;
    private $pricesRepo;

    public function __construct(
        PackagesRepository $packageRepo,
        PropertiesRepository $propertiesRepo,
        ExtraOrderRepository $extraOrderRepo,
        PricesRepository $pricesRepo
    ){
        $this->package = $packageRepo;
        $this->properties = $propertiesRepo;
        $this->extra_order = $extraOrderRepo;
        $this->price = $pricesRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        // product data
        $package_info = $this->package->update($data);

        // properties
        $package_info['properties'] = $this->properties->update($data['package_id'], $data['properties']);

        // price
        $package_info['price'] = $this->price->update($data['package_id'], $data['price']);

        // extra
        $package_info['extra'] = $this->extra_order->update($data['package_id'], $data['extra']);
        
        return $this->absorb([
            'status' => 200,
            'message' => 'Product Packages Updated',
            'data' => $package_info,
        ]);
    }

}
