<?php

namespace App\Http\Services\Packages;

use App\Http\Services\BaseService;

use App\Data\Repositories\Packages\PackagesRepository;
use App\Data\Repositories\Packages\PropertiesRepository;
use App\Data\Repositories\Packages\ExtraOrderRepository;
use App\Data\Repositories\Packages\PricesRepository;

class CreatePackageService extends BaseService
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
        // continue inserting
        foreach ($data as $key => $value) {
            $packages = $this->package->create($value);
            if(!$packages['continue']){
                continue;
            }
            $properties = $this->properties->create($packages['id'], $value['properties']);
            $prices = $this->price->create($packages['id'], $value['price']);
            $extra = $this->extra_order->create($packages['id'], $value['extra']);
        }

        return $this->absorb([
            'status' => 200,
            'message' => 'Packages inserted',
            'data' => [],
        ]);
        
    }

}
