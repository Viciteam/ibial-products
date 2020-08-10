<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;

use App\Http\Services\BaseService;

class InviteToTeamService extends BaseService
{   
    private $company;

    public function __construct(
        CompanyRepository $companyRepo
    ){
        $this->company = $companyRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        // initiate 
        $feedback = [];
        if(!isset($data['invitee'])){
            return $this->absorb([
                'status' => 500,
                'message' => 'Invitee must not be null'
            ]);
        }

        if(!isset($data['team_id'])){
            return $this->absorb([
                'status' => 500,
                'message' => 'Team ID must not be null'
            ]);
        }

        // insert user as per team
        foreach ($data['connection'] as $key => $value) {
            $value['invitee'] = $data['invitee'];
            $value['team_id'] = $data['team_id'];
            $value['status'] = "connected";

            // inject to DB
            $info = $this->company->insertInvitation($value);
            array_push($feedback, $info);
        }

        return $this->absorb([
            'status' => 200,
            'message' => 'Members Successfully Added',
            'data' => $feedback,
        ]);
        
    }

}
