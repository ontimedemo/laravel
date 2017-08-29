<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'email', 'firebase_uid', 'first_name', 'last_name'
    ];
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
    protected $appends = ['teams'];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members');
    }

    public function getTeamsAttribute()
    {
        return $this->teams()->get()->makeHidden('pivot');
    }
}
