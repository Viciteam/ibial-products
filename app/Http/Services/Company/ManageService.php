<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;

use App\Http\Services\BaseService;

class ManageService extends BaseService
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
        // change roles
        if(isset($data['roles'])){
            foreach ($data['roles'] as $rolekey => $rolevalue) {
                $this->company->changeRole($rolevalue);
            }
        }

        // change permissions
        if(isset($data['permissions'])){
            foreach ($data['permissions'] as $rolekey => $rolevalue) {
                $this->company->changePermissions($rolevalue);
            }
        }

        return $this->absorb([
            'status' => 200,
            'message' => 'Roles and Permissions Updated',
            'data' => $feedback,
        ]);
        
    }

}
