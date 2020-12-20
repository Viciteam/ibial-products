<?php


namespace App\Data\Repositories\Property;



use App\Data\Models\Packages\PackagesModel; 

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
class PropertyRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $package_model;
    private $property_model;
    private $property_meta_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PackagesModel $packageModel,
        PropertyModel $propertyModel,
        PropertyMetaModel $propertyMetaModel
    ){
        $this->package_model = $packageModel;
        $this->property_model = $propertyModel;
        $this->property_meta_model = $propertyMetaModel;
    }

    /**
     * Insert Property
     *
     * @param   array  $info  Property Information
     *
     * @return  int        id
     */
    public function create(array $info)
    {
        if(!isset($info['sku'])){
            $info['sku'] = $this->skuGenerator();
        }
        $info['image'] = json_encode($info['image']);

        // initialize model
        $prods = $this->property_model->init($info);
       
        if (!$prods->validate($info)) {
            $errors = $prods->getErrors();
            return '';
        }

        //region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            return '';
        }
        // dd($prods->id);
        
        return $prods->id;
    }

    /**
     * SKU Generator
     */
    public function skuGenerator()
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";  
        srand((double)microtime()*1000000); 
        $i = 0; 
        $pass = '' ; 

        while ($i <= 7) { 
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
        } 

        return $pass; 
    }

    /**
     * Update Product
     *
     * @param   int    $id    Product ID
     * @param   array  $data  data info
     *
     * @return  boolean        true
     */
    public function update(int $id, array $data)
    {
        if(!isset($data['sku'])){
            $data['sku'] = $this->skuGenerator();
        }
        $data['image'] = json_encode($data['image']);

        // initialize model
        $prods = $this->property_model->find($id);

        if (!$prods) {
            return false;
        }

        //region Data insertion
        if (isset($data['id'])) {
            unset($data['id']);
        }

        $prods->fill($data);

        //region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            return false;
        }
        // dd($prods->id);
        
        return true;
    }

    /**
     * Delete Product
     *
     * @param   int  $id  product id
     *
     * @return  boolean    true
     */
    public function delete(int $id)
    {
        $prods = $this->property_model->find($id);

        if (!$prods) {
            return false;
        }
        //endregion Existence check

        //region Data deletion
        if (!$prods->delete()) {
            $errors = $prods->getErrors();
            return false;
        }

        return true;
    }

    /**
     * Get All Product List
     * 
     * @return  array       producs
     */
    public function all($data)
    {
        // init property model
        $property_model = $this->property_model;
        
        if(isset($data['limit']) && isset($data['page'])){
            // for max pagination
            $for_pagination = $property_model->get()->count();

            // get max number of pages
            $max_pags = $for_pagination / $data['limit'];

            // get skip value
            $skip = ($data['page'] == "1" ? 0 : ($data['page'] == "2" ? $data['limit'] : $data['limit'] * ($data['page'] - 1)));
            $property_model = $property_model->skip($skip)->take($data['limit'])->get();
        } else {
            $property_model = $property_model->get();
        }

        $product_info = $this->returnToArray($property_model);

        if(empty($product_info)){
            return [
                'status' => 400,
                'message' => 'No Product has been loaded',
            ];
        }

        $with_meta = $this->getMeta($product_info);

        return [
            'status' => 200,
            'message' => 'Product Successfully Loaded',
            'meta' => [
                'max_pages' => ceil($max_pags)
            ],
            'data' => $with_meta,
        ];
    }

    public function getMeta(array $data)
    {
        $final_return = [];
        foreach($data as $key => $value) {
            $meta_information = $this->returnToArray($this->property_meta_model->where("productid", $value['id'])->get());
            
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

    /**
     * Single Product
     *
     * @param   int  $id  product id
     *
     * @return  array       producs
     */
    public function single($id)
    {
        $product_info = $this->returnToArray($this->property_model->where('id', $id)->get());
        if(empty($product_info)){
            return [];
        }
        return $product_info;
    }

    /**
     * Get Details With Meta
     *
     * @param   array  $data  data with meta info
     *
     * @return  return         full Property Data
     */
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
            $related_based = [];
            
            // get reference info
            foreach ($data as $refkey => $refvalue) {
                
                $prod_name = explode(" ", strtolower(trim($refvalue['name'])));
                $prod_desc = explode(" ", strtolower(trim($refvalue['description'])));
                $prod_info = array_merge($prod_name, $prod_desc);
                
                array_merge($prod_info, $related_based);
                foreach ($prod_info as $pikey => $pivalue) {
                    if(!in_array($pivalue, $this->RelatedParams())){
                        array_push($related_based, $pivalue);
                    }
                    
                }
            }

            // get products that will match name and description
            foreach ($related_based as $rfkey => $rfvalue) {
                $dproduct = $this->returnToArray($this->property_model->where('name', 'like', '%'.$rfvalue.'%')->orWhere('description', 'like', '%'.$rfvalue.'%')->get());
                
                foreach ($dproduct as $dpkey => $dpvalue) {
                    array_push($related_products, $dpvalue['id']);
                }
            }
            
        }

        return $related_products;
        
    }

    public function RelatedParams()
    {
        $filters = ["this", "is", "the", "of", "for", "name", "product", "are"];
        return $filters;
    }

    public function packages($data)
    {
        $packages = $this->returnToArray($this->package_model->where('product_id', $data['product_id'])->get());

        dump($packages);
        # code...
    }

    
}
