<?php

namespace App\Http\Services\KB;

use App\Data\Repositories\KB\KnowledgeBaseRepository;



use App\Http\Services\BaseService;

class DeactivateEntryService extends BaseService
{   
    private $kb;

    public function __construct(
        KnowledgeBaseRepository $kbRepo
    ){
        $this->kb = $kbRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        // dump($data);
        if(!isset($data['id'])){
            return $this->absorb([
                'status' => 500,
                'message' => 'Must identify KB id'
            ]);
        }

    
        $kbid = $this->kb->deactivate($data);

        return $this->absorb([
            'status' => 200,
            'message' => 'Knowledge Base Successfully Deactivated'
        ]);
    }
    

}


