<?php

namespace App\Data\Models\Packages;


use App\Data\Models\BaseModel;

class PropertiesModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'package_properties';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'package_id',
        'properties_name',
        'properties_value',
    ];

    public $hidden = [];

    public $rules = [
        'package_id' => 'sometimes|required',
        'properties_name' => 'sometimes|required',
        'properties_value' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
