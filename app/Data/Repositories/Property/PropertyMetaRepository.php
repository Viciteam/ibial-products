<?php


namespace App\Data\Repositories\Property;

use App\Data\Models\Property\PropertyModel;
use App\Data\Models\Property\PropertyMetaModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class PropertyMetaRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $property_model;
    private $property_meta_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PropertyModel $propertyModel,
        PropertyMetaModel $propertyMetaModel
    ){
        $this->property_model = $propertyModel;
        $this->property_meta_model = $propertyMetaModel;
    }

    /**
     * Create Meta
     *
     * @param   array  $data  meta data
     *
     */
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

    /**
     * Update Meta
     *
     * @param   int    $id    product id
     * @param   array  $meta  meta information
     *
     */
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

    /**
     * Delete Meta
     *
     * @param   int  $id  Product id
     *
     * @return  boolean    true
     */
    public function delete(int $id)
    {
        // clear metas
        PropertyMetaModel::where("productid", $id)->delete();

        return true;
    }

    /**
     * Get Meta Keys
     *
     * @param   array  $data  data information
     *
     * @return  array        full product information
     */
    public function getMeta(array $data)
    {
        $final_return = [];
        foreach($data as $key => $value) {
            $meta_information = $this->returnToArray(PropertyMetaModel::where("productid", $value['id'])->get());
            
            // format return
            $meta_info_cats = [];
            foreach ($meta_information as $mikey => $mivalue) {
                array_push($meta_info_cats, $mivalue['metakey']);
            }

            // unique keys
            $meta_info_cats = array_unique($meta_info_cats);

            // rebuild response
            $rebuild_meta = [];
            foreach ($meta_info_cats as $fnkey => $fnvalue) {
                $rebuild_meta[$fnvalue] = [];
                foreach($meta_information as $fnikey => $fnivalue){
                    if($fnivalue['metakey'] == $fnvalue){
                        array_push($rebuild_meta[$fnvalue], $fnivalue['metavalue']);
                    }
                }
            }
            $value['meta'] = $rebuild_meta;
            array_push($final_return, $value);
        }
        return $final_return;
    }

    public function get_only_meta($data)
    {
        $rebuild_meta = [];
        foreach($data as $key => $value) {
            $meta_information = $this->returnToArray(PropertyMetaModel::where("productid", $value['id'])->get());
            
            $meta_info_cats = [];
            foreach ($meta_information as $mikey => $mivalue) {
                array_push($meta_info_cats, $mivalue['metakey']);
            }

            // unique keys
            $meta_info_cats = array_unique($meta_info_cats);

            // rebuild response
            foreach ($meta_info_cats as $fnkey => $fnvalue) {
                $rebuild_meta[$fnvalue] = [];
                foreach($meta_information as $fnikey => $fnivalue){
                    if($fnivalue['metakey'] == $fnvalue){
                        array_push($rebuild_meta[$fnvalue], $fnivalue['metavalue']);
                    }
                }
            }
            
        }
        return $rebuild_meta;
    }
    
    /**
     * Get Product ID's as per Meta
     *
     * @param   array  $metas  list if meta
     *
     * @return  array          product meta details
     */
    public function getMetaWithValue($metas)
    {   
        // init meta model
        $meta_query = $this->property_meta_model->whereIn('metavalue', $metas['meta']);

        if(isset($metas['limit']) && isset($metas['page'])){
            // for max pagination
            $for_pagination = $meta_query->get()->count();

            // get max number of pages
            $max_pags = $for_pagination / $metas['limit'];

            // get skip value
            $skip = ($metas['page'] == "1" ? 0 : ($metas['page'] == "2" ? $metas['limit'] : $metas['limit'] * ($metas['page'] - 1)));
            $meta_query = $meta_query->skip($skip)->take($metas['limit'])->get();
        } else {
            $meta_query = $meta_query->get();
        }

        $products_info = $this->returnToArray($meta_query);


        // get product Ids
        $product_ids = [];
        foreach ($products_info as $key => $value) {
            array_push($product_ids, $value['productid']);
        }

        // get full meta information
        $product_metas = [];
        foreach ($product_ids as $pikey => $pivalue) {
            $meta_items = [];
            $meta_items['id'] = $pivalue;
            $products_info = $this->returnToArray($this->property_meta_model->where('productid', "=", $pivalue)->get());

            // format return
            // get keys
            $meta_keys = [];
            foreach ($products_info as $key => $value) {
                array_push($meta_keys, $value['metakey']);
            }

            // get unique
            $key_list = array_unique($meta_keys);

            // reformat returns
            $to_returns = [];
            foreach ($key_list as $mkkey => $mkvalue) {
                $to_returns[$mkvalue] = [];
                foreach ($products_info as $pikey => $pivalue) {
                    if($pivalue['metakey'] == $mkvalue){
                        array_push($to_returns[$mkvalue], $pivalue['metavalue']);
                    }
                }
            }
            $meta_items['meta'] = $to_returns;
            array_push($product_metas, $meta_items);
        }

        if(empty($product_metas)){
            return [
                'status' => 400,
                'message' => 'No Product has been loaded',
            ];
        }
        
        $product_from_meta = $this->getDetailsWithMeta($product_metas);

        return [
            'status' => 200,
            'message' => 'Product Successfully Loaded',
            'meta' => [
                'max_pages' => ceil($max_pags)
            ],
            'data' => $product_from_meta,
        ];
    }

    public function getDetailsWithMeta($data)
    {
        $full_information = [];
        foreach ($data as $key => $value) {
            $full_data = $this->returnToArray($this->property_model->where('id', '=', $value['id'])->first());
            if(!empty($full_data)){
                $full_data['meta'] = $value['meta'];
                array_push($full_information, $full_data);
            }
        }
        
        return $full_information;
    }



    public function related($data)
    {
        $related_products = [];
        if(!empty($data)){

            $arranged_meta = [];
            // rearrange meta as per key ang get value
            foreach ($data as $key => $value) {
                foreach ($value as $metakey => $metavalue) {
                    if(!array_key_exists($metakey, $arranged_meta)){
                        $arranged_meta[$metakey] = [];
                    }
                    foreach ($metavalue as $mtkey => $mtvalue) {
                        array_push($arranged_meta[$metakey], $mtvalue);
                    }
                }
            }

            $meta_products = [];
            foreach ($arranged_meta as $amkey => $amvalue) {
                foreach ($amvalue as $amvkey => $amvvalue) {
                    $meta = $this->returnToArray($this->property_meta_model->where([["metakey", "=", $amkey],["metavalue", "like", "%".$amvvalue."%"]])->get());
                    foreach ($meta as $mtkey => $mtvalue) {
                        array_push($meta_products, $mtvalue['productid']);
                    }
                }
            }
            
           return $meta_products;
        }
    }
    
}
