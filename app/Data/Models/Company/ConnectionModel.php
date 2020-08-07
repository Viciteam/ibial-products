<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class ConnectionModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'business';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'name',
        'logo',
        'description',
        'hashtag',
        'location',
        'skills',
        'language',
    ];

    public $hidden = [];

    public $rules = [
        'name' => 'sometimes|required',
        'logo' => 'sometimes|required',
        'description' => 'sometimes|required',
        'hashtag' => 'sometimes|required',
        'location' => 'sometimes|required',
        'skills' => 'sometimes|required',
        'language' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
