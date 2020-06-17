<?php

namespace App\Data\Models\Packages;


use App\Data\Models\BaseModel;

class PackagesModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'package';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'product_id',
        'package_name',
        'package_description',
        'delivery',
        'images',
    ];

    public $hidden = [];

    public $rules = [
        'product_id' => 'sometimes|required',
        'package_name' => 'sometimes|required',
        'delivery' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
