<?php


namespace App\Data\Repositories\Logs;

use App\Data\Repositories\Packages\PackagesRepository;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class ViewLogsRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $property;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PackagesRepository $propertyRepo
    ){
        $this->property = $propertyRepo;
    }
    
    public function insert($data)
    {
        /**
         * Redis Log Format
         * viewlog:{user_id}
         * Log Limit 30
         */

        $limit = 30;

        $logs = Redis::get('viewlog:'.$data['user_id']);
        $logs = json_decode($logs);

        // if no current log, make a new log
        if($logs === NULL){
            $logs = [];
        }
        
        // pop last value as per limit
        $log_count = count($logs);
        if($log_count >= $limit){
            array_pop($logs);
        }

        array_unshift($logs, $data['product_id']);

        Redis::set('viewlog:'.$data['user_id'], json_encode($logs));

        return true;
    }
    
    public function get($data)
    {
        /**
         * Redis Log Format
         * viewlog:{user_id}
         * Log Limit 30
         */

        $limit = (isset($data['limit']) ? $data['limit'] : 5);

        // Get log
        $logs = Redis::get('viewlog:'.$data['user_id']);
        $logs = json_decode($logs);
        
        if($logs === NULL){
            return [];
        }
        
        $counter = 1;
        $get_log = [];
        foreach ($logs as $key => $value) {
            array_push($get_log, $value);
            if($counter == $limit){
                break;
            }
            $counter++;
        }

        return $get_log;
    }
    
    
}
