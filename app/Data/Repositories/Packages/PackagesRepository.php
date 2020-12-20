<?php


namespace App\Data\Repositories\Packages;

use App\Data\Models\Packages\PackagesModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class PackagesRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $package;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        PackagesModel $packageModel
    ){
        $this->package = $packageModel;
    }

    /**
     * Create Package for Product
     *
     * @param   array  $data  package info
     *
     * @return  array         package id's
     */
    public function create($data)
    {   
        if(isset($data["images"])){
            $data["images"] = json_encode($data["images"]);
        } else {
            $data["images"] = '';
        }
        
        $package = $this->package->init($data);
        
        if (!$package->validate($data)) {
            $errors = $package->getErrors();
            return [
                "continue" => false,
                "message" => "Validation issue",
                "error" => $errors,
                "id" => ''
            ];
        }

        if (!$package->save()) {
            $errors = $package->getErrors();
            return [
                "continue" => false,
                "message" => "Saving issue",
                "error" => $errors,
                "id" => ''
            ];
        }

        return [
            "continue" => true,
            "message" => "Package Successfully Inserted",
            "id" => $package->id
        ];
    }

    //TODO: Make check if data is ready to insert
    // public function check($data)
    // {
    //     // $data["images"] = json_encode($data["images"]);
    //     $package = $this->package->init($data);
    //     if (!$package->validate($data)) {
    //         $errors = $package->getErrors();
    //         // dump($errors);
    //     }
    //     // dump($package);
    // }

    /**
     * Get package information
     *
     * @param   int  $id  product id
     *
     * @return  array       package information
     */
    public function info($id)
    {
        $package = $this->returnToArray($this->package->where("id", "=", $id)->get());
        return $package;
    }
    
    public function update($data)
    {
        $id = $data['package_id'];
        $prods = $this->package->find($id);

        if (!$prods) {
            return false;
        }

        if (isset($data['package_id'])) {
            unset($data['package_id']);
        }

        $prods->fill($data);

        //region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            return false;
        }
        // dd($prods->id);
        
        return $this->returnToArray($this->package->where("id", "=", $id)->first());
    }
    
}
