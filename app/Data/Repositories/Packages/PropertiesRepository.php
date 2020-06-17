<?php


namespace App\Data\Repositories\Packages;

use App\Data\Models\Packages\PropertiesModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class PropertiesRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $properties;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PropertiesModel $propertiesModel
    ){
        $this->properties = $propertiesModel;
    }

    /**
     * Create property for Package
     *
     * @param   int  $package_id  package id
     * @param   array  $data        property data
     */
    public function create($package_id, $data)
    {
        foreach ($data as $key => $value) {
            $init_details = [];
            $init_details['package_id'] = $package_id;
            $init_details['properties_name'] = $key;
            $init_details['properties_value'] = $value;

            $properties = $this->properties->init($init_details);

            if (!$properties->validate($init_details)) {
                $errors = $properties->getErrors();
                continue;
            }
    
            if (!$properties->save()) {
                $errors = $properties->getErrors();
                continue;
            }
        }
    }

    /**
     * Get Property Info
     *
     * @param   array  $data  package data without property
     *
     * @return  array         package data with property
     */
    public function info($data)
    {
        $with_properties = [];
        foreach ($data as $key => $value) {
            $properties = $this->returnToArray($this->properties->where("package_id", "=", $value['id'])->get());
            $value['properties'] = $properties;
            array_push($with_properties, $value);
        }
        return $with_properties;
    }
    
    
}
