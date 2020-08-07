<?php

namespace App\Http\Services\KB;

use App\Data\Repositories\KB\KnowledgeBaseRepository;



use App\Http\Services\BaseService;

class AddEntryService extends BaseService
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
        if(!isset($data['title'])){
            return $this->absorb([
                'status' => 500,
                'message' => 'Title must not be null'
            ]);
        }

        if(!isset($data['created_by'])){
            return $this->absorb([
                'status' => 500,
                'message' => 'Missing Created by'
            ]);
        }

        // build missing parts
        $data['description'] = (isset($data['description']) && $data['description'] != "" ? $data['description'] : "<br />");
        $data['category'] = (isset($data['category']) ? $data['category'] : 0);
        $data['status'] = (isset($data['status']) ? $data['status'] : "draft");
        $data['attributes'] = (isset($data['attributes']) ? json_encode($data['attributes']) : json_encode([]));

        $kbid = $this->kb->add($data);
        $data['id'] = $kbid;

        return $this->absorb([
            'status' => 200,
            'message' => 'Knowledge Base Successfully Created',
            'data' => $data,
        ]);
    }
    

}
