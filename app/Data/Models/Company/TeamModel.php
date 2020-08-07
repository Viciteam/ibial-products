<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class TeamModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'teams';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'user_id',
        'business_id',
        'name',
        'description',
        'created_by',
    ];

    public $hidden = [];

    public $rules = [
        'user_id' => 'sometimes|required',
        'business_id' => 'sometimes|required',
        'name' => 'sometimes|required',
        'description' => 'sometimes|required',
        'created_by' => 'sometimes|required'
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
