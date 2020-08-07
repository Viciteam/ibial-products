<?php

namespace App\Data\Models\KB;


use App\Data\Models\BaseModel;

class KnowledgeBaseModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'kb';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'title',
        'description',
        'category',
        'status',
        'created_by',
        'attributes'
    ];

    public $hidden = [];

    public $rules = [
        'title' => 'sometimes|required',
        'description' => 'sometimes|required',
        'category' => 'sometimes|required',
        'status' => 'sometimes|required',
        'created_by' => 'sometimes|required',
        'attributes' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
