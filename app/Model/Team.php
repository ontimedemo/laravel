<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $team = 'teams';
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
    protected $fillable = ['name', 'url', 'owner_id'];
    protected $hidden = ['pivot'];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_members');
    }
}
