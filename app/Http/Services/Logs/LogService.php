<?php

namespace App\Http\Services\Logs;

use App\Data\Repositories\Logs\ViewLogsRepository;

use App\Http\Services\BaseService;

class LogService extends BaseService
{   
    private $logs;

    public function __construct(
        ViewLogsRepository $logs
    ){
        $this->logs = $logs;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        $logs = $this->logs->insert($data);

        return $this->absorb([
            'status' => 200,
            'message' => 'Log Inserted',
            'data' => [],
        ]);
        
    }

}
