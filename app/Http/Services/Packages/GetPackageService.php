<?php

namespace App\Http\Services\Packages;

use App\Http\Services\BaseService;

use App\Data\Repositories\Packages\PackagesRepository;
use App\Data\Repositories\Packages\PropertiesRepository;
use App\Data\Repositories\Packages\ExtraOrderRepository;
use App\Data\Repositories\Packages\PricesRepository;

class GetPackageService extends BaseService
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
    public function handle($data)
    {   
        $packages = $this->package->info($data);
        if(!empty($packages)){
            // get properties
            $packages = $this->properties->info($packages);

            // get prices
            $packages = $this->price->info($packages);

            // get extra orders
            $packages = $this->extra_order->info($packages);
            return $this->absorb([
                'status' => 200,
                'message' => 'Product Packages Loaded',
                'data' => $packages,
            ]);
        } else {
            return $this->absorb([
                'status' => 500,
                'message' => 'No package has been loaded',
            ]);
        }
        
    }

}
