<?php

namespace App\Http\Services\Logs;

use App\Data\Repositories\Logs\ViewLogsRepository;
use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;

use App\Http\Services\BaseService;

class GetLogService extends BaseService
{   
    private $logs;
    private $propertyRepo;
    private $propertyMeta;

    public function __construct(
        ViewLogsRepository $logs,
        PropertyRepository $propertyRepo,
        PropertyMetaRepository $propertyMeta
    ){
        $this->logs = $logs;
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
        $list_of_logs = [];
        $logs = $this->logs->get($data);
        foreach ($logs as $key => $value) {
            $list_of_products = $this->property->single($value);
            $list_of_products = $this->property_meta->getMeta($list_of_products);
            array_push($list_of_logs, $list_of_products[0]);
        }

        return $this->absorb([
            'status' => 200,
            'message' => 'Log Inserted',
            'data' => $list_of_logs
        ]);
        
    }

}
