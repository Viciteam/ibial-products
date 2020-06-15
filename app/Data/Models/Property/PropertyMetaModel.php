<?php

namespace App\Data\Models\Property;


use App\Data\Models\BaseModel;
// use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyMetaModel extends BaseModel
{
    // use SoftDeletes;

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'product_meta';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'productid',
        'metakey',
        'metavalue',
    ];

    public $hidden = [];

    public $rules = [
        'productid' => 'sometimes|required',
        'metakey' => 'sometimes|required',
        'metavalue' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
