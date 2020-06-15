<?php


namespace App\Data\Repositories\Property;

use App\Data\Models\Property\PropertyMetaModel;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class PropertyMetaRepository 
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
        PropertyMetaModel $propertyMetaModel
    ){
        $this->property_meta_model = $propertyMetaModel;
    }

    public function create(array $data)
    {   
        // regroup meta keys
        $insert_data = [];

        // preparation data
        foreach ($data['meta'] as $key => $value) {
            $meta_key = $key; // meta keys declaration
            $product_id = $data['product_id']; // product id declaration
            // as per meta
            foreach($value as $xkey => $xvalue){
                array_push($insert_data, ['productid' => $product_id, 'metakey' => $meta_key, 'metavalue' => $xvalue, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }
        }

        // insert multiple metas at once.
        PropertyMetaModel::insert($insert_data);
    }

    public function update(int $id, array $meta)
    {
        // clear metas
        PropertyMetaModel::where("productid", $id)->delete();

        $insert_data = [];
        // preparation data
        foreach ($meta as $key => $value) {
            $meta_key = $key; // meta keys declaration
            $product_id = $id; // product id declaration
            // as per meta
            foreach($value as $xkey => $xvalue){
                array_push($insert_data, ['productid' => $product_id, 'metakey' => $meta_key, 'metavalue' => $xvalue, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }
        }

        // insert multiple metas at once.
        PropertyMetaModel::insert($insert_data);
    }

    public function delete(int $id)
    {
        // clear metas
        PropertyMetaModel::where("productid", $id)->delete();

        return true;
    }

    
}
