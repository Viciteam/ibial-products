<?php

namespace App\Data\Models\Transaction;


use App\Data\Models\BaseModel;
// use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionModel extends BaseModel
{
    // use SoftDeletes;

    public $incrementing = true;
    protected $table = 'transaction';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'user_id',
        'product_id',
        'package_id',
        'transaction',
        'price',
        'frequency',
        'subscription'
    ];

    public $hidden = [];

    public $rules = [
        'user_id' => 'sometimes|required',
        'product_id' => 'sometimes|required',
        'package_id' => 'sometimes|required',
        'transaction' => 'sometimes|required',
        'price' => 'sometimes|required',
        'frequency' => 'sometimes|required',
        'subscription' => 'sometimes|required',
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
