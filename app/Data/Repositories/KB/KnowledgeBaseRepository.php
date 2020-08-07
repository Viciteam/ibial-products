<?php


namespace App\Data\Repositories\KB;

use App\Data\Models\KB\KnowledgeBaseModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class KnowledgeBaseRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $kb;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(    
        KnowledgeBaseModel $knowledgeBaseModel
    ){
        $this->kb = $knowledgeBaseModel;
    }

    public function add($data)
    {
        $prods = $this->kb->init($data);

        if (!$prods->validate($data)) {
            $errors = $prods->getErrors();
            dump($errors);
            return 'error on validate';
        }

        // region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            dump($errors);
            return 'error on saving';
        }
        
        return $prods->id;
    }

    public function edit($data)
    {
        $id = $data['id'];
        $prods = $this->kb->find($id);

        if (!$prods) {
            return false;
        }

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
        
        return $this->returnToArray($this->kb->where("id", "=", $id)->first());
    }

    public function deactivate($data)
    {
        $this->kb->where("id", "=", $data['id'])->update([
            "status" => "deactivated"
        ]);
    }
    
    
}
