<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;

use App\Http\Services\BaseService;

class UnInviteToTeamService extends BaseService
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
        foreach ($data['users'] as $key => $value) {
            $this->company->unInvite($value);
        }

        return $this->absorb([
            'status' => 200,
            'message' => "Team Member(s) deleted"
        ]);
    }

}
