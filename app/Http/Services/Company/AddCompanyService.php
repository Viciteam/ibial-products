<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;



use App\Http\Services\BaseService;

class AddCompanyService extends BaseService
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
        // insert company profile
        $id = $this->company->add($data);

        // dump($id);
        // add hashtags
        $this->company->addHashtags($data['hashtag']);

        $data['id'] = $id;
        return $this->absorb([
            'status' => 200,
            'message' => 'Compnay Created',
            'data' => $data,
        ]);

        // initiate 
    }

}
