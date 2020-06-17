<?php


namespace App\Data\Repositories\Packages;

use App\Data\Models\Packages\PricesModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class PricesRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $price;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PricesModel $pricesModel
    ){
        $this->price = $pricesModel;
    }

    /**
     * Create Package prices
     *
     * @param   int  $package_id  package id
     * @param   array  $data        prices data
     */
    public function create($package_id, $data)
    {
        foreach ($data as $key => $value) {
            $value['package_id'] = $package_id;
            $prices = $this->price->init($value);

            if (!$prices->validate($value)) {
                $errors = $prices->getErrors();
                continue;
            }
    
            if (!$prices->save()) {
                $errors = $prices->getErrors();
                continue;
            }
        }
    }

    /**
     * Package prices
     *
     * @param   array  $data package info without price
     *
     * @return  array         package info with price
     */
    public function info($data)
    {
        $with_prices = [];
        foreach ($data as $key => $value) {
            $prices = $this->returnToArray($this->price->where("package_id", "=", $value['id'])->get());
            $value['price'] = $prices;
            array_push($with_prices, $value);
        }
        return $with_prices;
    }
    
    
}
