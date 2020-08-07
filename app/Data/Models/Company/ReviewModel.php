<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class ReviewModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'review';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'user_id',
        'business_id',
        'description',
        'rate',
    ];

    public $hidden = [];

    public $rules = [
        'user_id' => 'sometimes|required',
        'business_id' => 'sometimes|required',
        'description' => 'sometimes|required',
        'rate' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
