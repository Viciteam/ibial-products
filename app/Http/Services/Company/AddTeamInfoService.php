<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;

use App\Http\Services\BaseService;

class AddTeamInfoService extends BaseService
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
        $team_id = $this->company->addTeamDetails($data);

        $data['id'] = $team_id;
        return $this->absorb([
            'status' => 200,
            'message' => 'Team Successfully Created',
            'data' => $data,
        ]);
    }

}
