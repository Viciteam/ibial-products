<?php

namespace App\Data\Models\Packages;


use App\Data\Models\BaseModel;

class PricesModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'price';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'package_id',
        'price',
        'subscription',
        'frequency',
        'currency',
    ];

    public $hidden = [];

    public $rules = [
        'package_id' => 'sometimes|required',
        'price' => 'sometimes|required',
        'subscription' => 'sometimes|required',
        'frequency' => 'sometimes|required',
        'currency' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
