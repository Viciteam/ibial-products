<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;

use App\Http\Services\BaseService;

class MembersService extends BaseService
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
        if(!isset($data['team'])){
            return $this->absorb([
                'status' => 500,
                'message' => 'Team ID must not be null'
            ]);
        }

        $filters = [["team_id", "=", $data['team']]];

        if(isset($data['filter'])){
            foreach ($data['filter'] as $key => $value) {
                $dfilter = [$key, "=", $value];
                array_push($filters, $dfilter);
            }
        }

        $info = $this->company->getMembers($filters);

        return $this->absorb([
            'status' => 200,
            'message' => 'Members for Team id '.$data['team'],
            'data' => $info,
        ]);


    }

}
