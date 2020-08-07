<?php


namespace App\Data\Repositories\Company;

use App\Data\Models\Company\BusinessModel;
use App\Data\Models\Company\HashtagModel;
use App\Data\Models\Company\TeamModel;

use App\Data\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class CompanyRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $business_model;
    private $hashtag_model;
    private $team_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        BusinessModel $businessModel,
        HashtagModel $hashtagModel,
        TeamModel $teamModel
    ){
        $this->business_model = $businessModel;
        $this->hashtag_model = $hashtagModel;
        $this->team_model = $teamModel;
    }

    public function add($data)
    {
        $data['created_by'] = json_encode($data['user_id']);
        $data['hashtag'] = json_encode($data['hashtag']);
        $data['skills'] = json_encode($data['skills']);
        $data['language'] = json_encode($data['language']);
        $data['logo'] = (isset($data['logo']) || $data['logo'] != "" ? $data['logo'] : "");

        $prods = $this->business_model->init($data);

        if (!$prods->validate($data)) {
            $errors = $prods->getErrors();
            // dump($errors);
            // return 'error on validate';
        }

        // region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            // dump($errors);
            // return 'error on saving';
        }
        
        return $prods->id;

    }


    public function addHashtags($hashtags)
    {
        // dump($hashtags);

        foreach ($hashtags as $key => $value) {
            // check if hashtag exist
            if($this->hashCheck($value)){
                $this->hashtag_model->where("tag_name", "=", $value)->increment("tag_count");
            } else {
                $this->hashtag_model->create([
                    'tag_name' => $value,
                    'tag_count' => 1
                ]);
            }
        }
    }
    
    public function hashCheck($hashtag)
    {
        if($this->hashtag_model->where("tag_name", "=", $hashtag)->exists()){
            return true;
        } else {
            return false;
        }
    }

    public function addTeamDetails($data)
    {
        // dump($data);

        $prods = $this->team_model->init($data);

        if (!$prods->validate($data)) {
            $errors = $prods->getErrors();
            // dump($errors);
            // return 'error on validate';
        }

        // region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            // dump($errors);
            // return 'error on saving';
        }
        
        return $prods->id;
    }
    
    
}
