<?php

namespace App\Data\Models\Property;


use App\Data\Models\BaseModel;
// use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyModel extends BaseModel
{
    // use SoftDeletes;

    public $incrementing = true;
    protected $table = 'product';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'sku',
        'name',
        'description',
        'image',
        'status',
        'ownerid',
        'storeid',
        'pricing'
    ];

    public $hidden = [];

    public $rules = [
        'sku' => 'sometimes|required',
        'name' => 'sometimes|required',
        'ownerid' => 'sometimes|required',
        'pricing' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
