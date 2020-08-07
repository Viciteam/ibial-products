<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class HashtagModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'hashtags';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'tag_name',
        'tag_count'
    ];

    public $hidden = [];

    public $rules = [
        'tag_name' => 'sometimes|required',
        'tag_count' => 'sometimes|required'
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
