<?php


namespace App\Data\Repositories\Property;

use App\Data\Models\Property\PropertyModel;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class PropertyRepository 
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
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the Product.',
                'meta' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the Product.',
                'meta' => [
                    'errors' => $errors,
                ],
            ];
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

    
}
