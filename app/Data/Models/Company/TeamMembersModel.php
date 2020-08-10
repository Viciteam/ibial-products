<?php

namespace App\Data\Models\Company;


use App\Data\Models\BaseModel;

class TeamMembersModel extends BaseModel
{
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'team_members';

    public $casts = [
        'id' => 'int'
    ];

    public $fillable = [
        'user_id',
        'team_id',
        'position',
        'invitee',
        'status',
        'role',
        'permission',
    ];

    public $hidden = [];

    public $rules = [
        'user_id' => 'sometimes|required',
        'team_id' => 'sometimes|required',
        'position' => 'sometimes|required',
        'invitee' => 'sometimes|required',
        'status' => 'sometimes|required',
        'role' => 'sometimes|required',
        'permission' => 'sometimes|required'
    ];

     public function transactions()
     {
         return $this->morphMany();
     }
}
