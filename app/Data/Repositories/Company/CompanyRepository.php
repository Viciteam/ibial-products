<?php


namespace App\Data\Repositories\Company;

use App\Data\Models\Company\BusinessModel;
use App\Data\Models\Company\HashtagModel;
use App\Data\Models\Company\TeamModel;
use App\Data\Models\Company\TeamMembersModel;

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
    private $team_member_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        BusinessModel $businessModel,
        HashtagModel $hashtagModel,
        TeamModel $teamModel,
        TeamMembersModel $teamMemberModel
    ){
        $this->business_model = $businessModel;
        $this->hashtag_model = $hashtagModel;
        $this->team_model = $teamModel;
        $this->team_member_model = $teamMemberModel;
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
        $data['attributes'] = (isset($data['attributes']) ? json_encode($data['attributes']) : json_encode([]));

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

    public function insertInvitation($data)
    {
        $prods = $this->team_member_model->init($data);

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

        $data['id'] = $prods->id;
        
        return $data;
    }

    public function changeRole($data)
    {
        $this->team_member_model->where("id", "=", $data['member_id'])->update([
            "role" => $data['change_to']
        ]);
    }

    public function changePermissions($data)
    {
        $this->team_member_model->where("id", "=", $data['member_id'])->update([
            "permission" => $data['change_to']
        ]);
    }


    
    
}
