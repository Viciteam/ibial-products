<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class BusinessModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'business';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'name',
        'description',
        'hashtag',
        'location',
        'skills',
        'language',
        'attributes',
        'created_by',
    ];

    public $hidden = [];

    public $rules = [
        'name' => 'sometimes|required',
        'description' => 'sometimes|required',
        'hashtag' => 'sometimes|required',
        'location' => 'sometimes|required',
        'skills' => 'sometimes|required',
        'language' => 'sometimes|required',
        'attributes' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
