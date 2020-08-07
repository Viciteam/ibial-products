<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class TeamMembersModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'team';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'user_id',
        'business_id',
        'position',
    ];

    public $hidden = [];

    public $rules = [
        'user_id' => 'sometimes|required',
        'business_id' => 'sometimes|required',
        'position' => 'sometimes|required'
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
