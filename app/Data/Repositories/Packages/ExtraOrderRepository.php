<?php


namespace App\Data\Repositories\Packages;

use App\Data\Models\Packages\ExtraOrderModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class ExtraOrderRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $property_meta_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        ExtraOrderModel $extraOrderModel
    ){
        $this->extra_order = $extraOrderModel;
    }

    public function create($package_id, $data)
    {
        foreach ($data as $key => $value) {
            $value['package_id'] = $package_id;
            $extra_order = $this->extra_order->init($value);
            
            if (!$extra_order->validate($value)) {
                $errors = $extra_order->getErrors();
                continue;
            }
    
            if (!$extra_order->save()) {
                $errors = $extra_order->getErrors();
                continue;
            }
        }
    }

    public function info($data)
    {
        $with_extra = [];
        foreach ($data as $key => $value) {
            $extra = $this->returnToArray($this->extra_order->where("package_id", "=", $value['id'])->get());
            $value['extra'] = $extra;
            array_push($with_extra, $value);
        }
        return $with_extra;
    }

    public function update($id, $data)
    {
        $properties = $this->extra_order->where('package_id', '=', $id)->delete();

        foreach ($data as $key => $value) {
            $value['package_id'] = $id;
            $extra_order = $this->extra_order->init($value);
            
            if (!$extra_order->validate($value)) {
                $errors = $extra_order->getErrors();
                continue;
            }
    
            if (!$extra_order->save()) {
                $errors = $extra_order->getErrors();
                continue;
            }
        }

        return $this->returnToArray($this->extra_order->where("package_id", "=", $id)->get());
    }
    
    
}
