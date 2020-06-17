<?php

namespace App\Data\Models\Packages;


use App\Data\Models\BaseModel;

class ExtraOrderModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'extra_order';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'package_id',
        'extra_name',
        'extra_description',
        'price',
        'subscription',
        'frequency',
    ];

    public $hidden = [];

    public $rules = [
        'package_id' => 'sometimes|required',
        'extra_name' => 'sometimes|required',
        'price' => 'sometimes|required',
        'subscription' => 'sometimes|required',
        'frequency' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
