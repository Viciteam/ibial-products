<?php


namespace App\Data\Repositories\Property;



use App\Data\Models\Property\PropertyModel;

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
    private $property_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PropertyModel $propertyModel
    ){
        $this->property_model = $propertyModel;
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
    public function all()
    {
        $product_info = $this->returnToArray($this->property_model->get());
        if(empty($product_info)){
            return [];
        }
        return $product_info;
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

    
}
