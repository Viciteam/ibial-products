<?php

namespace App\Http\Services\Company;

use App\Data\Repositories\Company\CompanyRepository;

use App\Http\Services\BaseService;

class SuggestedService extends BaseService
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
        $hashtags = $this->company->getHashtags($data);
        dump($hashtags);

    }

}
